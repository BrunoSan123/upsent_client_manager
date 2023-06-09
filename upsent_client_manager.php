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

function get_task_data($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_tasks';
    $page = $request->get_param('page') ? absint($request->get_param('page')) : 1;
    $per_page = $request->get_param('per_page') ? absint($request->get_param('per_page')) : 10;
    $offset = ($page - 1) * $per_page;
    $task_data = $wpdb->get_results("SELECT * FROM $table_name LIMIT $per_page OFFSET $offset");
    return $task_data;
}

function get_task_data_by_status($request){
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_tasks';
    $page = $request->get_param('page') ? absint($request->get_param('page')) : 1;
    $per_page = $request->get_param('per_page') ? absint($request->get_param('per_page')) : 10;
    $status=$request->get_param('status');
    $offset = ($page - 1) * $per_page;
    $task_data = $wpdb->get_results("SELECT * FROM $table_name WHERE states='$status' LIMIT $per_page OFFSET $offset");
    return $task_data;
}

function get_task_delivered($request){
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_tasks';
    $page = $request->get_param('page') ? absint($request->get_param('page')) : 1;
    $per_page = $request->get_param('per_page') ? absint($request->get_param('per_page')) : 10;
    $entregue=$request->get_param('entregue');
    $offset = ($page - 1) * $per_page;
    $task_data = $wpdb->get_results("SELECT * FROM $table_name WHERE entregue=$entregue LIMIT $per_page OFFSET $offset");
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

function custom_xls_download() {
    // Verificar se a query string 'xls_download' está presente
    if (isset($_GET['xls_download'])) {
        // Iniciar o buffer de saída
        ob_start();
        global $wpdb;
        $table_name = $wpdb->prefix . 'employer_report';
        $employer = isset($_POST['employer_filter']) ? $_POST['employer_filter'] : '';
        $month=isset($_POST['meses'])?$_POST['meses']:'';
        $month_number=date_parse($month)['month'];
        

        $output = "";
    
        
            $results = $wpdb->get_results("SELECT * FROM $table_name WHERE employer_name='$employer' AND month_='$month_number'");
        
    
    
            //$customers_data = array(array('customers_id' => '1', 'customers_firstname' => 'Chris', 'customers_lastname' => 'Cavagin', 'customers_email' => 'chriscavagin@gmail.com', 'customers_telephone' => '9911223388'), array('customers_id' => '2', 'customers_firstname' => 'Richard', 'customers_lastname' => 'Simmons', 'customers_email' => 'rsimmons@media.com', ' clientes_telefone' => '9911224455'), array('customers_id' => '3', 'customers_firstname' => 'Steve', 'customers_lastname' => 'Beaven', 'customers_email' => 'ateavebeaven@gmail.com', 'customers_telephone' => '8855223388'), array('customers_id' => '4', 'customers_firstname' => 'Howard', 'customers_lastname' => 'Rawson', 'customers_email' => 'howardraw@gmail. com', 'customers_telephone' => '9911334488'), array('customers_id' => '5', 'customers_firstname' => 'Rachel', 'customers_lastname' => 'Dyson', 'customers_email' => 'racheldyson@ gmail.com', 'customers_telephone' => '9912345388'));
            $output .= "
                  <meta charset='UTF-8'>
                  <table>
                  <th style='border:1px solid black; background:yellow;'>DATA</th>
                  <th style='border:1px solid black; background:yellow;'>EMPRESA</th>
                  <th style='border:1px solid black; background:yellow;'>PROJETO</th>
                  <th style='border:1px solid black; background:yellow;'>CLIENTE</th>
                  <th style='border:1px solid black; background:yellow;'>N° CHAMADO</th>
                  <th style='border:1px solid black; background:lightgreen;'>VALOR A RECEBER</th>
                  <th style='border:1px solid black; background:lightgreen;'>VALOR HORA ADICIONAL</th>
                  <th style='border:1px solid black; background:lightgreen;'>VALOR KM A RECEBER</th>
                  <th style='border:1px solid black; background:yellow;'>CUSTOS ADICIONAIS</th>
                  <th style='border:1px solid black; background:lightgreen;'>DESCRITIVO ORÇAMENTO</th>
                  <th style='border:1px solid black; background:lightgreen;'>STATUS DO ORÇAMENTO</th>
                  <th style='border:1px solid black; background:lightgreen;'>RESPONSAVEL APROVAÇÃO</th>
                  <th style='border:1px solid black; background:lightgreen;'>VALOR ORÇAMENTO</th>
                  <th style='border:1px solid black; background: #00B0F0;'>NOME TÉCNICO</th>
                  <th style='border:1px solid black; background: #00B0F0;'>VALOR A RECEBER</th>
                  <th style='border:1px solid black; background: #00B0F0;'>vALOR KM</th>
                  <th style='border:1px solid black; background: #00B0F0;'>HE TEC</th>
                  <th style='border:1px solid black; background: #00B0F0;'>CUSTOS ADICIONAIS</th>
                  <th style='border:1px solid black; background: #00B0F0;'>VALOR ORÇAMENTO</th>
                  <th style='border:1px solid black; background: #FF0000;'>VALOR TEC JÁ FATURADO</th>
                  <th style='border:1px solid black; background: yellow;'>CIDADE/UF</th>
                  <th style='border:1px solid black; background: yellow;'>ENDEREÇO</th>
                  <th style='border:1px solid black; background: yellow;'>OBSERVAÇÃO DO CLIENTE</th>
                  <th style='border:1px solid black; background: yellow;'>OBSERVAÇÃO DA SOLUTION</th>
                  <th style='border:1px solid black; background: #D000FF;'>HORA DE INICIO</th>
                  <th style='border:1px solid black; background: #D000FF;'>HORA DE TERMINO</th>
                  <th style='border:1px solid black; background: #D000FF;'>QUANTIDADE DE HORAS</th>
                  <th style='border:1px solid black; background: #D000FF;'>DESCRITIVO ATENDIMENTO</th>
                  <th style='border:1px solid black; background: #D000FF;'>ORDEM DE SERVIÇO(RAT)</th>

                ";
    
            foreach ($results as $result) {
                $output .= "
                        <tr>
                          <td>$result->date_</td>
                          <td>$result->company</td>
                          <td>$result->project</td>
                          <td>$result->client</td>
                          <td>$result->call_number</td>
                          <td>$result->incoming_value</td>
                          <td>$result->aditional_value_per_hour</td>
                          <td>$result->incoming_value_per_km</td>
                          <td>$result->aditional_cousts</td>
                          <td>$result->descritive_budget</td>
                          <td>$result->status_budget</td>
                          <td>$result->aprovement_responseble</td>
                          <td>$result->value_budget</td>
                          <td>$result->employer_name</td>
                          <td>$result->incoming_value/td>
                          <td>$result->value_km</td>
                          <td>$result->he_tec</td>
                          <td>$result->aditional_cousts</td>
                          <td>$result->value_budget</td>
                          <td>$result->employer_featured_value</td>
                          <td>$result->city/$result->uf</td>
                          <td>$result->address_</td>
                          <td>$result->client_observation</td>
                          <td>$result->solution_observation</td>
                          <td>$result->start_time</td>
                          <td>$result->end_time</td>
                          <td>$result->month_total_time</td>
                          <td>$result->call_descritive</td>
                          <td>$result->service_order</td>
                        </tr>
                    ";
    
            }
            $output .= "</table>";
            echo $output;

                    // Definir cabeçalhos para forçar o download do arquivo XLS
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=reports-$employer-$month.xls");

        // Seu código PHP que gera o conteúdo do arquivo XLS

        // Encerrar o buffer de saída e enviar o arquivo XLS para o navegador
        ob_end_flush();

        // Encerrar a execução do script para evitar o carregamento da página
        exit();
    

        }


    
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

add_action('rest_api_init', function(){
    register_rest_route('upsent-api/v1','tasks/filter',array(
        'methods' => 'GET',
        'callback' => 'get_task_data_by_status',
        'permission_callback' => '__return_true' 
    ));
});

add_action('rest_api_init', function(){
    register_rest_route('upsent-api/v1','tasks/finished',array(
        'methods' => 'GET',
        'callback' => 'get_task_delivered',
        'permission_callback' => '__return_true' 
    ));
});

add_action('init', 'custom_xls_download');

if (class_exists('Inc\\Init')) {
    Inc\Init::register_services();
}
