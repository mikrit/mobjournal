<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Type extends ORM
{
	protected $_has_many = array(
		'methods' => array(
			'model'			=> 'method',
			'through'		=> 'methods_types',
			'foreign_key'	=> 'type_id',
		),
		'numbers' => array(
			'model'			=> 'number',
			//'through'		=> 'methods_types',
			'foreign_key'	=> 'type_id',
		)
	);

	public static function validation_type($values)
	{
		return Validation::factory($values)
			->rule('title', 'not_empty');
	}
}