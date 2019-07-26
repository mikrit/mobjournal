<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Material extends ORM
{
    protected $_has_many = array(
        'materials'  => array(
            'model'       => 'material_log',
            'foreign_key' => 'material_id',
        )
    );

    protected $_belongs_to = array(
        'number'	=> array(
            'model'			=> 'number',
            'foreign_key'	=> 'number_id',
        ),
    );

    public static function validation_method($values)
    {
        return Validation::factory($values)
            ->rule('title', 'not_empty');
    }
}