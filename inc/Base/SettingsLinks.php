<?php
/**
 * @package ClientManager 
 * */
namespace Inc\Base;


class SettingsLinks{
    protected $plugin;

    public function __construct()
    {
        $this->plugin =PLUGIN_BASE_DIR;
    }

    public function register(){
        add_filter("plugin_action_links_$this->plugin",array($this,'settings_links'));
    }

    public function settings_links($links){
        $settings_link='<a href="admin.php?page=employer_management">Configurações</a>';
        array_push($links,$settings_link);
        return $links;
    }
}