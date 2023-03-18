<?php
/**
 * @package ClientManager 
 * */

 namespace Inc\Base;

 class Activate
 {
   
    public static function activate(){
        self::create_task();
        flush_rewrite_rules();
    } 

    function create_task(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'my_tasks';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                task_name VARCHAR(50) NOT NULL,
                creation_data TIMESTAMP NOT NULL,
                task_address VARCHAR(50) NOT NULL,
                coord_x FLOAT(50) NOT NULL,
                coord_y FLOAT(50) NOT NULL,
                states  ENUM('parado','em andamento','concluido') NOT NULL,
                task_description TEXT(100) NOT NULL,
                PRIMARY KEY  (id)
                );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
 }