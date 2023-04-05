<?php

/**
 * @package ClientManager
 */

namespace Inc\Pages;

class Admin
{
    
    public function register(){
        add_action('admin_menu',array($this,'add_admin_pages'));    
    }

    public function add_admin_pages(){
        $user='administrator';
        $args=array(
            'role'=>'administrator',
            'orderby' => 'user_nicename',
            'order'   => 'ASC'
           
        );
        $allUsers=get_users($args);
        $get_user_role=get_role($user);
        add_menu_page('EmployerManagement','EMT','manage_options','employer_management',array($this,'admin_dashboard'),'dashicons-editor-table',110);
        if($allUsers && $get_user_role->name=="administrator"){

        
        add_submenu_page(
            'employer_management',
            __( 'Cadastro de tarefas', 'textdomain' ),
            __( 'Cadastro de tarefas', 'textdomain' ),
            'manage_options',
            'cadastro',
            array($this,'admin_index'),
            '2'
        );

        add_submenu_page(
            'employer_management',
            __( 'Tarefas ', 'textdomain' ),
            __( 'Tarefas disponiveis', 'textdomain' ),
            'manage_options',
            'tarefas',
            array($this,'task_subpage'),
            '3'
        );

        add_submenu_page(
            'employer_management',
            __( 'Histórico ', 'textdomain' ),
            __( 'Histórico dos funcionarios', 'textdomain' ),
            'manage_options',
            'historico',
            array($this,'logs_subpage'),
            '4'
        );
    
    }

        
            add_submenu_page(
                'employer_management',
                __( 'Suas tarefas', 'textdomain' ),
                __( 'Tarefas do usuario', 'textdomain' ),
                'manage_options',
                'usuario',
                 array($this,'task_user_subpage'),
                 '5'
    
            );
    }

    public function admin_dashboard(){
        require_once PLUGIN_PATH.'templates/dashboard.php';
    }

    public function admin_index(){
        // load templates
        require_once PLUGIN_PATH.'templates/admin.php';
    }

    public function task_subpage(){
        require_once PLUGIN_PATH.'templates/task_view.php';
    }

    public function task_user_subpage(){
        require_once PLUGIN_PATH.'templates/usuario.php';
    }

    public function logs_subpage(){
        require_once PLUGIN_PATH.'templates/historico.php';
    }
}