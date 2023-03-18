<?php

/**
 * @package ClientManager
 */

 namespace Inc;

 final class Init{

    public static function get_services(){
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class
        ];
    }
    public static function register_services()
    {
        foreach(self::get_services() as $class){
            $service = self::instantiate($class);
            if(method_exists($service,'register')){
                $service->register();
            }
        }
    }

    private static function instantiate($class){
        $service = new $class();
        return $service;
    }
 }

 /* use Inc\Base\Activate;
 use Inc\Base\Deactivate;
 use Inc\Pages\Admin;

 class ClientManager
 {
    public $plugin;

    function __construct()
    {
        $this->plugin=plugin_basename(__FILE__);
    }
    
    function register(){
        add_action('admin_enqueue_scripts',array($this,'enqueue'));
        add_action('admin_menu',array($this,'add_admin_pages'));
        add_filter("plugin_action_links_$this->plugin",array($this,'settings_link'));
    }

    public function settings_link($links){
        $settings_link='<a href="admin.php?page=employer_management">Configurações</a>';
        array_push($links,$settings_link);
        return $links;
    }

    public function add_admin_pages(){
        add_menu_page('EmployerManagement','EMT','manage_options','employer_management',array($this,'admin_index'),'dashicons-editor-table',110);
    }

    public function admin_index(){
        // load templates
        require_once plugin_dir_path(__FILE__).'templates/admin.php';
    }

    function activate(){
        Activate::activate();
    }
    
    

    function uninstall(){
        
    }

    function custom_post_type(){
        register_post_type('tarefas',['public'=>true,'label'=>'Tarefas']);
    }

    function enqueue(){
        // load css and js
        wp_enqueue_style('upsent_plugin_style',plugins_url('/assets/mystyle.css',__FILE__));
        wp_enqueue_script('upsent_plugin_script',plugins_url('/assets/myscript.js',__FILE__));
    }
 }

 if(class_exists('ClientManager')){
    $clientManager= new ClientManager();
    $clientManager->register();
 }


 register_activation_hook(__FILE__,array($clientManager,'activate'));
 register_deactivation_hook(__FILE__,array('Deactivate','deactivate')); */