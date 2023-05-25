<?php
/**
 * @package ClientManager 
 * */

 namespace Inc\Base;

 class Activate
 {
   
    public static function activate(){
        self::create_client();
        self::create_sub_task();
        self::create_task();
        self::create_table_image();
        self::create_report_table();
        self::create_logs();
        self::user_coords();
        self::create_role();
        flush_rewrite_rules();
    } 

    public static function create_task(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'my_tasks';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                task_name VARCHAR(50) NOT NULL,
                creation_data TIMESTAMP NOT NULL,
                task_address VARCHAR(50) NOT NULL,
                coord_x FLOAT(50) NOT NULL,
                coord_y FLOAT(50) NOT NULL,
                states  VARCHAR(50) NOT NULL,
                cep     VARCHAR(50) NOT NULL,
                company VARCHAR(50) NOT NULL,
                task_description TEXT(100) NOT NULL,
                funcionaro_responsavel VARCHAR(50) NOT NULL DEFAULT '',
                client VARCHAR(50) NOT NULL,
                subtasks mediumint(9),
                concluida BOOLEAN NOT NULL DEFAULT 0,
                entregue  BOOLEAN NOT NULL DEFAULT 0,
                employeer_position_x FLOAT(50) NOT NULL,
                employeer_position_Y FLOAT(50) NOT NULL,
                conclued_img  JSON,
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
            task_start_time TIME NOT NULL,
            task_end_time TIME NOT NULL,
            log_description VARCHAR(50) NOT NULL,
            task_name VARCHAR(50) NOT NULL,
            sign VARCHAR(50) NOT NULL,
            states VARCHAR(50) NOT NULL,
            task_id mediumint(9) NOT NULL,
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

    public static function create_sub_task(){
        global $wpdb;
        $table_name=$wpdb->prefix.'my_subtasks';
        $sql_user_subtasks="CREATE TABLE IF NOT EXISTS $table_name(
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            task_name VARCHAR(50) NOT NULL,
            creation_data TIMESTAMP NOT NULL,
            states  VARCHAR(50) NOT NULL,
            task_description TEXT(100) NOT NULL,
            concluida BOOLEAN NOT NULL DEFAULT 0,
            PRIMARY KEY(id)
        )";
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($sql_user_subtasks);

    }

    public static function create_table_image(){
        global $wpdb;
        $table_name=$wpdb->prefix.'my_task_images';
        $sql_image_query="CREATE TABLE IF NOT EXISTS $table_name(
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nome VARCHAR(255) NOT NULL,
            task_id mediumint(9) NOT NULL,
            PRIMARY KEY(id),
            FOREIGN KEY(task_id) REFERENCES wp_my_tasks(id) ON DELETE CASCADE
        )";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_image_query);
    }

    public static function create_report_table(){
        global $wpdb;
        $table_name=$wpdb->prefix.'employer_report';
        $sql_report="CREATE TABLE IF NOT EXISTS $table_name(
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            call_number VARCHAR(50) NOT NULL,
            company VARCHAR(50) NOT NULL,
            client VARCHAR(50) NOT NULL,
            employer_name VARCHAR(50) NOT NULL,
            employer_incoming_value VARCHAR(50) NOT NULL,
            task_id mediumint(9),
            month_total_time mediumint(9),
            date_ VARCHAR(50) NOT NULL,
            project VARCHAR(50) NOT NULL,
            incoming_value VARCHAR(50) NOT NULL,
            aditional_value_per_hour VARCHAR(50) NOT NULL,
            km FLOAT(50) NOT NULL,
            incoming_value_per_km VARCHAR(50) NOT NULL,
            aditional_cousts VARCHAR(50) NOT NULL,
            status_budget  VARCHAR(50) NOT NULL,
            value_budget VARCHAR(50) NOT NULL,
            value_per_km VARCHAR(50) NOT NULL,
            value_km VARCHAR(50) NOT NULL,
            he_tec VARCHAR(50) NOT NULL,
            employer_featured_value VARCHAR(50) NOT NULL,
            address_ VARCHAR(50) NOT NULL,
            client_observation VARCHAR(50) NOT NULL,
            solution_observation VARCHAR(50) NOT NULL,
            aprovement_responseble VARCHAR(50) NOT NULL,
            budget_describe VARCHAR(50) NOT NULL,
            city VARCHAR(50) NOT NULL,
            uf VARCHAR(50) NOT NULL,
            start_time TIME NOT NULL,
            end_time TIME NOT NULL,
            call_descritive VARCHAR(50) NOT NULL,
            service_order  VARCHAR(50) NOT NULL,
            month_ VARCHAR(50) NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY(task_id) REFERENCES wp_my_tasks(id) ON DELETE CASCADE
        )";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_report);
    }


    public static function create_role(){
        add_role('funcionario','Funcionario',array(
            'read'=>true,
            'activate_plugins'=>true,
            'deactivate_plugins'=>true,
            'edit_plugins'=>true,
            'manage_options'=>true,

        ));

    }
    
 }