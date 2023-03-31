<?php

/**
 * Plugin Name:     Upsent Client Manager
 * Plugin URI:      https://upsent.com.br
 * Description:     Gerenciador de tarefas para monitoramento de funcionarios
 * Version:         1.0.0
 * Author:          Bruno Barreto
 * Author URI:      without
 * Text Domain:     upsent cleint manager
 *
 * @package         ClientManager
 * @copyright       Copyright (c) Upsent
 */

use Inc\Base\Activate;
use Inc\Base\Deactivate;

if (!defined('ABSPATH')) die;
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once  dirname(__FILE__) . '/vendor/autoload.php';
}


define('PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_BASE_DIR', plugin_basename(__FILE__));

function activate_employer_manager_plugin()
{
    Activate::activate();
}

function deactivate_employer_manager_plugin()
{
    Deactivate::deactivate();
}

register_activation_hook(__FILE__, 'activate_employer_manager_plugin');
register_deactivation_hook(__FILE__, 'deactivate_employer_manager_plugin');

function get_task_data()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_tasks';
    $task_data = $wpdb->get_results("SELECT * FROM $table_name");
    return $task_data;
}


function get_task_by_name($data)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_tasks';
    $task_data_user = $wpdb->get_results("SELECT * FROM $table_name WHERE funcionaro_responsavel='$data'");
    return $task_data_user;
}

function delete_task($id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_tasks';
    $wpdb->delete(
        $table_name,
        array('id' => $id),
        array('%d')
    );
}

function teste_route($request){
	$id = $request->get_param( 'identification' );
	return $id;
}

function update_deliverance($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_tasks';
    $wpdb->update(
        $table_name,
        array('entregue' => $request->get_param('entregue')),
        array('id' => $request->get_param('id'))
    );
    return 'ok';
}

function get_employer_position()
{
    global $wpdb;
    $table_name=$wpdb->prefix.'user_coords';
    $employer_position=$wpdb->get_results("SELECT * FROM $table_name");
    return $employer_position;
}



add_action('rest_api_init', function () {
    register_rest_route('upsent-api/v1', 'tasks', array(
        'methods' => 'GET',
        'callback' => 'get_task_data'
    ));
});

add_action('rest_api_init', function () {
    register_rest_route('upsent-api/v1', 'tasks/(?P<funcionario-responsavel>\w+)', array(
        'methods' => 'GET',
        'callback' => 'get_task_by_name'
    ));
});

add_action('rest_api_init', function () {
    register_rest_route('upsent-api/v1', 'tasks/(?P<id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'delete_task'
    ));
});

add_action('rest_api_init', function () {
    register_rest_route('upsent-api/v1', 'tasks/', array(
        'methods' => 'PUT',
        'callback' => 'update_deliverance'     
    ));
});

add_action('rest_api_init', function(){
    register_rest_route('upsent-api/v1','employeer_position/',array(
        'methods' => 'GET',
        'callback' => 'get_employer_position' 
    ));
});


if (class_exists('Inc\\Init')) {
    Inc\Init::register_services();
}
