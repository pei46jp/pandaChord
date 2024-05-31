<?php

use Fuel\Core\Date;
use Orm\Model;

    class Model_Users extends Model {
        protected static $_connection = "production";
        protected static $_table_name = "users";
        protected static $_primary_key = array('id');
        protected static $_observers = array(
            'Orm\\Observer_CreatedAt' => array(
                'events' => array('before_insert'),
                'mysql_timestamp' => true,
                'property' => 'created_at',
            ),
            'Orm\\Observer_UpdatedAt' => array(
                'events' => array('before_save'),
                'mysql_timestamp' => true,
                'property' => 'updated_at',
            )
        );
        protected static $_properties = array(
            'id',
            'username' => array(
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
            'email' => array(
                'data_type' => 'varchar',
                'label' => 'Email'
            ),
            'group' => array(
                'data_type' => 'varchar',
                'label' => 'group'
            ),
            'last_login',
            'login_hash',
            'profile_fields',
            'created_at',
            'updated_at',
        );
    }