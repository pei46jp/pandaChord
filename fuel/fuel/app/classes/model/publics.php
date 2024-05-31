<?php

use Fuel\Core\Date;
use Orm\Model;

    class Model_Publics extends Model {
        protected static $_connection = "production";
        protected static $_table_name = "publics";
        protected static $_primary_key = array('id');
        protected static $_properties = array(
            'id',
            'publication' => array(
                'data_type' => 'varchar',
                'label' => 'Publication Type'
            )
        );
    }