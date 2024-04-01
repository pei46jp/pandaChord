<?php

use Fuel\Core\Date;
use Orm\Model;

    class Model_Tags extends Model {
        protected static $_connection = "production";
        protected static $_table_name = "tags";
        protected static $_primary_key = array('id');
        protected static $_properties = array(
            'id',
            'tag_name' => array(
                'data_type' => 'varchar',
                'label' => 'Tag Name',
                'validation' => array(
                    'required',
                    'max_length' => array(20)
                ),
            ),
            'created_at' => array(
                'data_type' => 'datetime'
            ),
            'updated_at' => array(
                'data_type' => 'datetime'
            ),
            'deleted_at' => array(
                'data_type' => 'datetime'
            )
        );

        protected static $_soft_delete = array(
            'deleted_field' => 'deleted_at'
        );
        
        protected static function _pre_insert($data) {
            $data['created_at'] = Date::time()->format('%Y-%m-%d %H:%M:%S');
            $data['updated_at'] = Date::time()->format('%Y-%m-%d %H:%M:%S');
            return $data;
        }

        protected static function _pre_update($data) {
            $data['updated_at'] = Date::time()->format('%Y-%m-%d %H:%M:%S');
            return $data;
        }
    }