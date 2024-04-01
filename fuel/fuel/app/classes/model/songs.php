<?php

use Fuel\Core\Date;
use Orm\Model;

    class Model_Songs extends Model {
        protected static $_connection = "production";
        protected static $_table_name = "songs";
        protected static $_primary_key = array('id');
        protected static $_properties = array(
            'id',
            'title' => array(
                'data_type' => 'varchar',
                'label' => 'Title',
                'default' => 'Untitled.',
                'validation' => array(
                    'max_length' => array(50)
                ),
            ),
            'artist_name' => array(
                'data_type' => 'varchar',
                'label' => 'Artist Name',
                'validation' => array(
                    'max_length' => array(50)
                ),
            ),
            'user_name' => array(
                'data_type' => 'varchar',
                'label' => 'User Name',
                'validation' => array(
                    'max_length' => array(20)
                ),
            ),
            'lyrics' => array(
                'data_type' => 'text',
                'label' => 'Lyrics',
            ),
            'chord' => array(
                'data_type' => 'varchar',
                'label' => 'Chord',
            ),
            'memo' => array(
                'data_type' => 'varchar',
                'label' => 'Memo',
                'validation' => array(
                    'max_length' => array(100)
                ),
            ),
            'is_public' => array(
                'data_type' => 'int',
                'label' => 'Publication',
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
        
        protected static $_belongs_to = array(
            'artist' => array(
                'key_from' => 'artist_name',
                'model_to' => 'Model_Artists',
                'key_to' => 'id',
            ),
            'user' => array(
                'key_from' => 'user_name',
                'model_to' => 'Model_Users',
                'key_to' => 'id',
            ),
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