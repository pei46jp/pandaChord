<?php

use Fuel\Core\Date;
use Orm\Model;

    class Model_Artists extends Model {
        protected static $_connection = "production";
        protected static $_table_name = "artists";
        protected static $_primary_key = array('id');
        protected static $_observers = array(
            'Orm\\Observer_CreatedAt' => array(
                'events' => array('before_insert'),
                'mysql_timestamp' => true,
                // 'mysql_timestamp' => false,
                'property' => 'created_at',
                // 'datatype' => 'datetime',
            ),
            'Orm\\Observer_UpdatedAt' => array(
                'events' => array('before_save'),
                'mysql_timestamp' => true,
                // 'mysql_timestamp' => false,
                'property' => 'updated_at',
                // 'datatype' => 'datetime',
            )
        );
        protected static $_properties = array(
            'id',
            'artist_name' => array(
                'data_type' => 'varchar',
                'label' => 'Artist Name',
                'validation' => array(
                    'required',
                    'max_length' => array(50)
                ),
            ),
            'created_at',
            'updated_at',
            'deleted_at'
        );

        protected static $_soft_delete = array(
            'deleted_field' => 'deleted_at'
        );
    }