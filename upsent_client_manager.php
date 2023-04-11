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


function get_task_by_name($request)
{
    global $wpdb;
    $funcionario=$request->get_param('funcionaro_responsavel');
    $table_name = $wpdb->prefix . 'my_tasks';
    // Get page and per_page parameters
    $page = $request->get_param('page') ? absint($request->get_param('page')) : 1;
    $per_page = $request->get_param('per_page') ? absint($request->get_param('per_page')) : 10;
    $entregue=$request->get_param('entregue');
    $offset = ($page - 1) * $per_page;
    $task_data_user = $wpdb->get_results("SELECT * FROM $table_name WHERE funcionaro_responsavel='$funcionario' AND entregue=$entregue  LIMIT $per_page OFFSET $offset");
    $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE funcionaro_responsavel='$funcionario'");
    // Calculate the total number of pages
    $total_pages = ceil($total_tasks / $per_page);

        // Add pagination data to the response
        $response = array(
            'tasks' => $task_data_user,
            'total_pages' => $total_pages,
            'total_tasks' => $total_tasks,
            'current_page' => $page,
            'per_page' => $per_page,
            'entregue'=>$entregue,
        );
    return $task_data_user;
}

function delete_task($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_tasks';
    $id=$request->get_param('id');
    $wpdb->delete(
        $table_name,
        array('id' => $id),
        array('%d')
    );
    return "item deletado com sucesso";
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
        'callback' => 'get_task_data',
        'permission_callback' => '__return_true'
    ));
});

add_action('rest_api_init', function () {
    register_rest_route('upsent-api/v1', 'tasks_employee/', array(
        'methods' => 'GET',
        'callback' => 'get_task_by_name',
        'permission_callback' => '__return_true'
    ));
});

add_action('rest_api_init', function () {
    register_rest_route('upsent-api/v1', 'tasks/delete', array(
        'methods' => 'DELETE',
        'callback' => 'delete_task',
        'permission_callback' => '__return_true'
    ));
});

add_action('rest_api_init', function () {
    register_rest_route('upsent-api/v1', 'tasks/', array(
        'methods' => 'PUT',
        'callback' => 'update_deliverance',
        'permission_callback' => '__return_true'     
    ));
});

add_action('rest_api_init', function(){
    register_rest_route('upsent-api/v1','employeer_position/',array(
        'methods' => 'GET',
        'callback' => 'get_employer_position',
        'permission_callback' => '__return_true' 
    ));
});


if (class_exists('Inc\\Init')) {
    Inc\Init::register_services();
}
