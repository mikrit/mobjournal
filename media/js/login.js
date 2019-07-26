$(document).ready(function() // автофокус на первую строку
{
	$('#myModal').on('shown.bs.modal', function(){
		$(this).find('input:first').focus();
	});

	$('#myModal2').on('shown.bs.modal', function(){
		$(this).find('input:first').focus();
	});

	$("#error_username").hide();
	$("#error_username").empty();

	$('#password').keydown(function(event){
		if(event.keyCode == 13){
			$("#login_ajax").trigger('click');
		}
	});

	$("#login_ajax").click(function()// при нажатии кнопки "Вход"
	{
		$("#error").hide();
		$("#error").empty();

		var l = Ladda.create(this).start();

		var login = $('#login').val();
		var password = $('#password').val();
		var remember = $('input:checkbox:checked').val();

		$.ajax({
			type: "POST",
			url: "auth/login",
			dataType: "json",
			data: {
				login: login,
				password: password,
				remember: remember
			},
			success: function(result){
				if(result.code == 'error') // если вернулся статус с ошибкой
				{
					var error = result.error;
					$("#error").append(error).show(); // показываем блок с сообщением об ошибке
					l.stop();
				}
				if(result.code == 'success') // если вернулся статус без ошибки
				{
					window.location.href = '/main';
				}
			}
		});
	});

	/*Дублирование кода, но пока не могу придумать как это обойти*/

	var letters = '1234567890zxcvbnmasdfghjklqwertyuiopQWERTYUIOPLKJHGFDSAZXCVBNM_';

	/*Проверка на вводимые символы --> Нужна ли? Может сделать при переходе на другое поле проверку на не подходящие символы?*/
	$('#username').on('keyup keypress', function(e){
		if(e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40 || e.keyCode == 46){
			return true;
		}else{
			return (letters.indexOf(String.fromCharCode(e.which)) != -1);
		}
	});

	/*Проверка имя пользователя на существования в базе*/
	$('#username').focusout(function(){
		var error = '';
		var username = $('#username').val();
		var lenght_string = username.length;

		if(lenght_string >= 4){
			$.ajax({
				type: "POST",
				url: "auth/isset_login",
				dataType: "json",
				data: {
					username: username
				},
				success: function(result){
					if(result.code == 'error') // если вернулся статус с ошибкой
					{
						$("#error_username").empty();
						$("#error_username").append(result.message).show(); // показываем блок с сообщением об ошибке
						$('#username').css({'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(174, 25, 18, .7)'});
					}

					if(result.code == 'success') // если вернулся статус без ошибки
					{
						$("#error_username").hide();
						$("#error_username").empty();
						$('#username').css({'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(16, 174, 25, .7)'});
					}
				}
			});
		}
		else // выводим ошибку, так как login должен быть больше 4 символов
		{
			$("#error_username").empty();
			$("#error_username").append('<div class="alert alert-danger form-control2" role="alert">Имя пользователя должно быть больше 3 символов</div>').show(); // показываем блок с сообщением об ошибке
			$('#username').css({'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(174, 25, 18, .7)'});
		}
	});

	/*Проверка Емайла пользователя на существования в базе*/
	$('#email').focusout(function(){
		var error = '';
		var email = $('#email').val();

		//регулярка на email

		$.ajax({
			type: "POST",
			url: "auth/isset_email",
			dataType: "json",
			data: {
				email: email
			},
			success: function(result){
				if(result.code == 'error') // если вернулся статус с ошибкой
				{
					$("#error_email").empty();
					$("#error_email").append(result.message).show(); // показываем блок с сообщением об ошибке
					$('#email').css({'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(174, 25, 18, .7)'});
				}

				if(result.code == 'success') // если вернулся статус без ошибки
				{
					$("#error_email").hide();
					$("#error_email").empty();
					$('#email').css({'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(16, 174, 25, .7)'});
				}
			}
		});
	});

	/*Проверка пароля на 6 и более символов*/
	$('#password_reg').focusout(function(){

		var password = $('#password_reg').val();
        var confirm_password = $('#confirm_password_reg').val();
		var lenght_string = password.length;

		if(lenght_string < 6) // если вернулся статус с ошибкой
		{
			$("#error_password_reg").empty();
			$("#error_password_reg").append('<div class="alert alert-danger form-control2" role="alert">Пароль должен быть 6 или более символов</div>').show(); // показываем блок с сообщением об ошибке
			$('#password_reg').css({'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(174, 25, 18, .7)'});
		}
		else
		{
			$("#error_password_reg").hide();
			$("#error_password_reg").empty();
			$('#password_reg').css({'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(16, 174, 25, .7)'});
		}

        if(password == confirm_password)
        {
            $("#error_password_confirm_reg").hide();
            $("#error_password_confirm_reg").empty();
            $('#confirm_password_reg').css({'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(16, 174, 25, .7)'});
        }
	});

	/*Проверка паролей на совпадение*/
	$('#confirm_password_reg').focusout(function(){
		var password = $('#password_reg').val();
		var confirm_password = $('#confirm_password_reg').val();

			if(password != confirm_password) // если вернулся статус с ошибкой
			{
				$("#error_password_confirm_reg").empty();
				$("#error_password_confirm_reg").append('<div class="alert alert-danger form-control2" role="alert">Пароли не совпадают</div>').show(); // показываем блок с сообщением об ошибке
				$('#confirm_password_reg').css({'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(174, 25, 18, .7)'});
			}
			else
			{
				$("#error_password_confirm_reg").hide();
				$("#error_password_confirm_reg").empty();
				$('#confirm_password_reg').css({'box-shadow': 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(16, 174, 25, .7)'});
			}
	});

	/*Обработка при нажатии кнопки "Регистрация"*/
	$("#registration_ajax").click(function()
	{
		/*здесь нужно при переходе на другое поле динамически вызывать проверку ошибок...*/
		$("#error_reg").hide();
		$("#error_reg").empty();

		var username = $('#username').val();
		var email = $('#email').val();
		var password = $('#password_reg').val();
		var password_confirm = $('#password_confirm_reg').val();

		$.ajax({
			type: "POST",
			url: "auth/registration",
			dataType: "json",
			data: {
				username: username,
				email: email,
				password: password,
				password_confirm: password_confirm
			},
			success: function(result){
				if(result.code == 'error') // если вернулся статус с ошибкой
				{
                    $("#error_username").hide();
                    $("#error_username").empty();

                    $("#error_email").hide();
                    $("#error_email").empty();

                    $("#error_password_reg").hide();
                    $("#error_password_reg").empty();

                    $("#error_password_confirm_reg").hide();
                    $("#error_password_confirm_reg").empty();

					var error = result.error;
					/*здесь нужно под каждым полем выводить ошибку и посмотреть как это смотрится*/
					$("#error_reg").append(error).show(); // показываем блок с сообщением об ошибке
				}
				if(result.code == 'success') // если вернулся статус без ошибки
				{
					var error = result.error;
					$("#error_reg").append(error).show(); // показываем блок с сообщением
					/*!!!Тут нужно придумать или сразу попадаем в систему или требуем подтверждения о регистрации!!??!!*/
					//window.location.href = 'main';
				}
			}
		});
	});
});