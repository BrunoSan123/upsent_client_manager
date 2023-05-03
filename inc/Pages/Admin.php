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
  

        add_menu_page('EmployerManagement','EMT','manage_options','employer_management',array($this,'admin_dashboard'),'dashicons-editor-table',110);
        

        
        add_submenu_page(
            'employer_management',
            __( 'Cadastro de tarefas', 'textdomain' ),
            __( 'Cadastro de tarefas', 'textdomain' ),
            'administrator',
            'cadastro',
            array($this,'admin_index'),
            '2'
        );

        add_submenu_page(
            'employer_management',
            __( 'Tarefas ', 'textdomain' ),
            __( 'Tarefas disponiveis', 'textdomain' ),
            'administrator',
            'tarefas',
            array($this,'task_subpage'),
            '3'
        );

        add_submenu_page(
            'employer_management',
            __( 'Histórico ', 'textdomain' ),
            __( 'Histórico dos funcionarios', 'textdomain' ),
            'administrator',
            'historico',
            array($this,'logs_subpage'),
            '4'
        );
        add_submenu_page(
            'employer_management',
            __( 'Tarefas Entrregues', 'textdomain' ),
            __( 'Tarefas Entregues', 'textdomain' ),
            'administrator',
            'tarefas_concluidas',
            array($this,'tasks_finished'),
            '5'
        );
        add_submenu_page(
            'employer_management',
            __( 'Relatórios', 'textdomain' ),
            __( 'Relatórios', 'textdomain' ),
            'administrator',
            'relatórios',
            array($this,'reports'),
            '7'
        );
        
    
       add_submenu_page(
                'employer_management',
                __( 'Suas tarefas', 'textdomain' ),
                __( 'Tarefas do usuario', 'textdomain' ),
                'funcionario',
                'usuario',
                 array($this,'task_user_subpage'),
                 '6'
    
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

    public function tasks_finished(){
        require_once PLUGIN_PATH.'templates/tarefas_concluidas.php';
    }

    public function reports(){
        require_once PLUGIN_PATH.'templates/relatórios.php';
    }
}