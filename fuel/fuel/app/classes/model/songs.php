<?php

use Fuel\Core\Date;
use Fuel\Core\DB;
use Orm\Model;

    class Model_Songs extends Model {
        protected static $_connection = "production";
        protected static $_table_name = "songs";
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
            'created_at',
            'updated_at',
            'deleted_at'
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

        public static function delete_song_by_id($id) {
            return DB::delete(self::$_table_name)->where('id', '=', $id)->execute();
        }

        public static function get_songs_by_ids($ids) {
            return DB::select()->from(self::$_table_name)->where('id', 'in', $ids)->execute()->as_array();
        }

        public static function get_song_by_id($id) {
            return DB::select()->from(self::$_table_name)->where('id', '=', $id)->execute()->as_array();
        }

    }