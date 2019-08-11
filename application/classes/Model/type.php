<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Type extends ORM
{
	protected $_has_many = array(
		'methods' => array(
			'model'			=> 'method',
			'through'		=> 'methods_types',
			'foreign_key'	=> 'type_id',
		)
	);
}