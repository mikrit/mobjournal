<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Method extends ORM
{
	protected $_has_many = array(
		'numbers'  => array(
			'model'       => 'number',
			'through'     => 'methods_numbers',
			'foreign_key' => 'method_id',
		),
		'types' => array(
			'model'			=> 'type',
			'through'		=> 'methods_types',
			'foreign_key'	=> 'method_id',
		)
	);

	public static function validation_method($values)
	{
		return Validation::factory($values)
			->rule('title', 'not_empty');
	}
}