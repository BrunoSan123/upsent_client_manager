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
        add_menu_page('EmployerManagement','EMT','manage_options','employer_management',array($this,'admin_index'),'dashicons-editor-table',110);

        add_submenu_page(
            'employer_management',
            __( 'Tarefas ', 'textdomain' ),
            __( 'Tarefas disponiveis', 'textdomain' ),
            'manage_options',
            'tarefas',
            array($this,'task_subpage'),
            '2'
        );
    }

    public function admin_index(){
        // load templates
        require_once PLUGIN_PATH.'templates/admin.php';
    }

    public function task_subpage(){
        require_once PLUGIN_PATH.'templates/task_view.php';
    }
}