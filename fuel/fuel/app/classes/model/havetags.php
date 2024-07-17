<?php

use Fuel\Core\Date;
use Fuel\Core\DB;
use Orm\Model;

    class Model_HaveTags extends Model {
        protected static $_connection = "production";
        protected static $_table_name = "have_tags";
        protected static $_primary_key = ['tag_id', 'song_id'];
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
            'tag_id' => array(
                'data_type' => 'int,'
            ),
            'song_id' => array(
                'data_type' => 'int',
            ),
            'created_at',
            'updated_at',
            'deleted_at'
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
                'cascade_save' => true,
                'cascade_delete' => false,
            )
        );

        public static function get_song_id_by_tag_id($tag_id) {
            return DB::select('song_id')->from(self::$_table_name)->where('tag_id', '=', $tag_id)->execute()->as_array();
        }

        public static function delete_by_song_id($song_id) {
            return DB::delete(self::$_table_name)->where('song_id', '=', $song_id)->execute();
        }
    }