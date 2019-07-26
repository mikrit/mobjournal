<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Materiallog extends ORM
{
    protected $_belongs_to = array(
        'material'	=> array(
            'model'			=> 'material',
            'foreign_key'	=> 'material_id',
        ),
    );

    public static function validation_method($values)
    {
        return Validation::factory($values)
            ->rule('log', 'not_empty');
    }
}