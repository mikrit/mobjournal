<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * ORM Auth driver.
 *
 * @package    Kohana/Auth
 * @author     Kohana Team
 * @copyright  (c) 2007-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Kohana_Auth_ORM extends Auth
{
	/**
	 * Проверка пользователя в системе.
	 *
	 * @param   mixed    $role Имя роли строка, роль ОРМ объект, или массив с именами ролей
	 * @return  boolean
	 */
	public function logged_in($role = NULL)
	{
		// Получаем текущего пользователя из сессии
		$user = $this->get_user();

		if (!$user)
		{
			return FALSE;
		}

		// Если $user является обектом класса Model_User и $user->loaded()
		if ($user instanceof Model_User AND $user->loaded())
		{
			// Если мы не имеем роль то дальнейших проверок не требуется
			if (!$role)
			{
				return TRUE;
			}

			if (is_array($role))
			{
				// Получаем все роли
				$roles = ORM::factory('Role')
							->where('name', 'IN', $role)
							->find_all()
							->as_array(NULL, 'id');

				// Make sure all the roles are valid ones
				if (count($roles) !== count($role))
				{
					return FALSE;
				}
			}
			else
			{
				if (!is_object($role))
				{
					// Загружаем роль
					$roles = ORM::factory('Role', array('name' => $role));

					if (!$roles->loaded())
					{
						return false;
					}
				}
				else
				{
					$roles = $role;
				}
			}

			return $user->has('roles', $roles);
		}
	}

	/**
	 * Вход пользователя в систему
	 *
	 * @param   string   $username
	 * @param   string   $password
	 * @param   boolean  $remember  enable autologin
	 * @return  boolean
	 */
	protected function _login($user, $password, $remember)
	{
		if (!is_object($user))
		{
			$username = $user;

			// Load the user
			$user = ORM::factory('User');
			$user->where($user->unique_key($username), '=', $username)->find();
		}

		if (is_string($password))
		{
			// Создаём хэш пароля
			$password = $this->hash($password);
		}

		// Если пароли совпадают, входим
		if ($user->has('roles', ORM::factory('Role', array('name' => 'login'))) AND $user->password === $password)
		{
			if ($remember === TRUE)
			{
				// Token data
				$data = array(
					'user_id'    => $user->pk(),
					'expires'    => time() + $this->_config['lifetime'],
					'user_agent' => sha1(Request::$user_agent),
				);

				// Create a new autologin token
				$token = ORM::factory('User_Token')
							->values($data)
							->create();

				// Set the autologin cookie
				Cookie::set('authautologin', $token->token, $this->_config['lifetime']);
			}

			// Finish the login
			$this->complete_login($user);

			return TRUE;
		}

		// Login failed
		return FALSE;
	}

	/**
	 * Заставляет пользователю войти, не указывая пароль.
	 *
	 * @param   mixed    $user                    username string, or user ORM object
	 * @param   boolean  $mark_session_as_forced  mark the session as forced
	 * @return  boolean
	 */
	public function force_login($user, $mark_session_as_forced = FALSE) // Не используется в данный момент
	{
		if ( ! is_object($user))
		{
			$username = $user;

			// Load the user
			$user = ORM::factory('User');
			$user->where($user->unique_key($username), '=', $username)->find();
		}

		if ($mark_session_as_forced === TRUE)
		{
			// Mark the session as forced, to prevent users from changing account information
			$this->_session->set('auth_forced', TRUE);
		}

		// Run the standard completion
		$this->complete_login($user);
	}

	/**
	 * Автоматический вход пользователя в систему с помощью authautologin cookie.
	 *
	 * @return  mixed
	 */
	public function auto_login()
	{
		if ($token = Cookie::get('authautologin'))
		{
			// Загрузка признака и пользователя
			$token = ORM::factory('User_Token', array('token' => $token));

			if ($token->loaded() AND $token->user->loaded())
			{
				if ($token->user_agent === sha1(Request::$user_agent))
				{
					// Сохранить признак, чтобы создать новый уникальный признак
					$token->save();

					// Set the new token
					Cookie::set('authautologin', $token->token, $token->expires - time());

					// Complete the login with the found data
					$this->complete_login($token->user);

					// Automatic login was successful
					return $token->user;
				}

				// Token is invalid
				$token->delete();
			}
		}

		return FALSE;
	}

	/**
	 * Получаем текущего пользователя из сессии (с проверкой auto_login).
	 * Возвращаем $default если пользователь не вошёл в систему.
	 *
	 * @param   mixed    $default to return in case user isn't logged in
	 * @return  mixed
	 */
	public function get_user($default = NULL)
	{
		$user = parent::get_user($default);

		if ($user === $default)
		{
			// выбор для автоматического входа, галочка "Запомнить"
			if (($user = $this->auto_login()) === FALSE)
				return $default;
		}

		return $user;
	}

	/**
	 * Log a user out and remove any autologin cookies.
	 *
	 * @param   boolean  $destroy     completely destroy the session
	 * @param	boolean  $logout_all  remove all tokens for user
	 * @return  boolean
	 */
	public function logout($destroy = FALSE, $logout_all = FALSE)
	{
		// Set by force_login()
		$this->_session->delete('auth_forced');

		if ($token = Cookie::get('authautologin'))
		{
			// Delete the autologin cookie to prevent re-login
			Cookie::delete('authautologin');

			// Clear the autologin token from the database
			$token = ORM::factory('User_Token', array('token' => $token));

			if ($token->loaded() AND $logout_all)
			{
				// Delete all user tokens. This isn't the most elegant solution but does the job
				$tokens = ORM::factory('User_Token')->where('user_id','=',$token->user_id)->find_all();
				
				foreach ($tokens as $_token)
				{
					$_token->delete();
				}
			}
			elseif ($token->loaded())
			{
				$token->delete();
			}
		}

		return parent::logout($destroy);
	}

	/**
	 * Get the stored password for a username.
	 *
	 * @param   mixed   $user  username string, or user ORM object
	 * @return  string
	 */
	public function password($user)
	{
		if ( ! is_object($user))
		{
			$username = $user;

			// Load the user
			$user = ORM::factory('User');
			$user->where($user->unique_key($username), '=', $username)->find();
		}

		return $user->password;
	}

	/**
	 * Complete the login for a user by incrementing the logins and setting
	 * session data: user_id, username, roles.
	 *
	 * @param   object  $user  user ORM object
	 * @return  void
	 */
	protected function complete_login($user)
	{
		$user->complete_login();

		return parent::complete_login($user);
	}

	/**
	 * Compare password with original (hashed). Works for current (logged in) user
	 *
	 * @param   string  $password
	 * @return  boolean
	 */
	public function check_password($password)
	{
		$user = $this->get_user();

		if ( ! $user)
			return FALSE;

		return ($this->hash($password) === $user->password);
	}

} // End Auth ORM
