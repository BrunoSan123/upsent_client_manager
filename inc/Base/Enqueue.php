<?php
/**
 * @package ClientManager 
 * */
namespace Inc\Base;

class Enqueue{
    public function register(){
        add_action('admin_enqueue_scripts',array($this,'enqueue'));
    }

    function enqueue(){
        // load css and js
        wp_enqueue_style('upsent_plugin_style',PLUGIN_URL.'assets/mystyle.css');
        wp_enqueue_script('upsent_plugin_script',PLUGIN_URL.'assets/myscript.js');
    }
}