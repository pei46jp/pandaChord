<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * -----------------------------------------------------------------------------
 *  Global database settings
 * -----------------------------------------------------------------------------
 *
 *  Set database configurations here to override environment specific
 *  configurations
 *
 */

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


return array(

    'default' => array(
        'type'          => 'pdo',
        'connection'    => array(
            'dsn'           => 'pgsql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'],
            // 'dsn'           => 'pgsql:host=localhost;port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'],
            'username'      => $_ENV['DB_USER'],
            'password'      => $_ENV['DB_PW'],
            'persistent'    => false,
            'compress'      => false,
        ),
        'identifier'    => '"',
        'table_prefix'  => '',
        'charset'       => 'utf8',
        'enable_cache'  => true,
        'profiling'     => false,
        'readonly'      => false,
    ),

    'production' => array(
        'type'          => 'pdo',
        'connection'    => array(
            'dsn'           => 'pgsql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'],
            'username'      => $_ENV['DB_USER'],
            'password'      => $_ENV['DB_PW'],
            'persistent'    => false,
            'compress'      => false,
        ),
        'identifier'    => '"',
        'table_prefix'  => '',
        'charset'       => 'utf8',
        'enable_cache'  => true,
        'profiling'     => false,
        'readonly'      => false,
    ),
);
