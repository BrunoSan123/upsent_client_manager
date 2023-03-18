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

 if(!defined('ABSPATH')) die;
 if(file_exists(dirname(__FILE__).'/vendor/autoload.php')){
    require_once  dirname(__FILE__).'/vendor/autoload.php';
 }

define('PLUGIN_PATH',plugin_dir_path(__FILE__));
define('PLUGIN_URL',plugin_dir_url(__FILE__));
define('PLUGIN_BASE_DIR',plugin_basename(__FILE__));

function activate_employer_manager_plugin(){
    Activate::activate();
}

function deactivate_employer_manager_plugin(){
    Deactivate::deactivate();
}

register_activation_hook(__FILE__,'activate_employer_manager_plugin');
register_deactivation_hook(__FILE__,'deactivate_employer_manager_plugin');

if(class_exists('Inc\\Init')){
    Inc\Init::register_services();
}