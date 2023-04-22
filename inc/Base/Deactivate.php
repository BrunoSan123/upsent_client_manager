<?php
/**
 * @package ClientManager 
 * */
namespace Inc\Base;

 class Deactivate
 {
    public static function deactivate(){
        remove_role('funcionario');
        flush_rewrite_rules();
    }
 }