<h1>Parte do usuario</h1>
<?php 
    global $wpdb;
    $user='administrator';
    $args=array(
        'role'=>'administrator',
        'orderby' => 'user_nicename',
        'order'   => 'ASC'
       
    );
    $allUsers=get_users($args);
    $get_user_role=get_role($user);
    print_r($allUsers);
    if($allUsers && $get_user_role->name =='administrator'){
        echo 'hello funcionario';
    }else{
        echo 'sem funcionario';
    }

    
?>