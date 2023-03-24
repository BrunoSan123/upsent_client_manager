<?php
/**
 * @package ClientManager 
 * */

 namespace Inc\Base;

 class Activate
 {
   
    public static function activate(){
        self::create_client();
        self::create_task();
        self::create_logs();
        self::user_coords();
        self::create_role();
        flush_rewrite_rules();
    } 

    public static function create_task(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'my_tasks';
        $table_reference ='wp_clients(id)';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                task_name VARCHAR(50) NOT NULL,
                creation_data TIMESTAMP NOT NULL,
                task_address VARCHAR(50) NOT NULL,
                coord_x FLOAT(50) NOT NULL,
                coord_y FLOAT(50) NOT NULL,
                states  VARCHAR(50) NOT NULL,
                task_description TEXT(100) NOT NULL,
                funcionaro_responsavel VARCHAR(50) NOT NULL DEFAULT '',
                client mediumint(9),
                FOREIGN KEY (client) REFERENCES $table_reference ON DELETE CASCADE, 
                PRIMARY KEY  (id)
                );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public static function create_client(){
        global $wpdb;
        $table_name=$wpdb->prefix . 'clients';
        $sql_client="CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            client_name VARCHAR(50) NOT NULL,
            client_surname VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            cpf VARCHAR(100) NOT NULL,
            PRIMARY KEY (id)
        )";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_client);
    }

    public static function create_logs(){
        global $wpdb;
        $table_name=$wpdb->prefix.'logs';
        $sql_logs="CREATE TABLE IF NOT EXISTS $table_name(
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user VARCHAR(50) NOT NULL,
            log_description VARCHAR(50) NOT NULL,
            sign VARCHAR(50) NOT NULL,
            PRIMARY KEY(id)
        )";
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($sql_logs);
    }

    public static function user_coords(){
        global $wpdb;
        $table_name=$wpdb->prefix.'user_coords';
        $sql_user_cords="CREATE TABLE IF NOT EXISTS $table_name(
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            coord_x FLOAT(50) NOT NULL,
            coord_y FLOAT(50) NOT NULL,
            user VARCHAR(50) NOT NULL,
            PRIMARY KEY(id)
        )";
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($sql_user_cords);

    }


    public static function create_role(){
        add_role('funcionario','Funcionario',array(
            'read'=>true,
            'activate_plugins'=>true,
            'edit_plugins'=>true,
            'level_0'=>true
        ));

    }
    
 }