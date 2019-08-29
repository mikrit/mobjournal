<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Kohana_Helper {

	public static function get_list_orm($table, $column){
		$datas = array();
		$orm = ORM::factory($table)->find_all();

		foreach($orm as $val){
			$datas[$val->id] = $val->$column;
		}

		return $datas;
	}

	public static function get_list_orm_method($table, $column, $type_id){
		$datas = array();
		$types = ORM::factory($table, $type_id);
		$methods = $types->methods->find_all();

		foreach($methods as $val){
			$datas[$val->id] = $val->$column;
		}

		return $datas;
	}

	public static function get_list_orm_analizes($table, $column, $type_id){
		$datas = array();
		$types = ORM::factory($table, $type_id);
		$analyzes = $types->analyzes->find_all();

		foreach($analyzes as $val){
			$datas[$val->id] = $val->$column;
		}

		return $datas;
	}
}