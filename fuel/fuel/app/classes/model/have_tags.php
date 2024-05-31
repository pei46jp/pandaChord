<?php

use Fuel\Core\Date;
use Orm\Model;

    class Model_HaveTags extends Model {
        protected static $_connection = "production";
        protected static $_table_name = "have_tags";
        protected static $_primary_key = null;
        protected static $_properties = array(
            'tag_id' => array(
                'data_type' => 'int,'
            ),
            'song_id' => array(
                'data_type' => 'int',
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
            'tag' => array(
                'key_from' => 'tag_id',
                'model_to' => 'Model_Tags',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            ),
            'song' => array(
                'key_from' => 'song_id',
                'model_to' => 'Model_Songs',
                'key_to' => 'id',
                'cascade_save' => false,
                'cascade_delete' => false,
            )
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