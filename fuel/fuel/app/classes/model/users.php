<?php

use Fuel\Core\Date;
use Orm\Model;

    class Model_Users extends Model {
        protected static $_connection = "production";
        protected static $_table_name = "users";
        protected static $_primary_key = array('id');
        protected static $_properties = array(
            'id',
            'user_name' => array(
                'data_type' => 'varchar',
                'label' => 'User Name',
                'validation' => array(
                    'required',
                    'max_length' => array(20)
                ),
            ),
            'password' => array(
                'data_type' => 'varchar',
                'validation' => array(
                    'required',
                    'max_length' => array(255)
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
            $data['created_at'] = Date::forge()->get_timestamp();
            $data['updated_at'] = Date::forge()->get_timestamp();
            return $data;
        }

        protected static function _pre_update($data) {
            $data['updated_at'] = Date::forge()->get_timestamp();
            return $data;
        }
    }