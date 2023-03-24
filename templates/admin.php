<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trarefas</title>
</head>
<body class="upsent_plugin_manager">
    <header>
        <h1>Cadastro de Tarefas</h1>
    </header>
  

    <section>
    <?php 
             global $wpdb;
             $user_table=$wpdb->prefix.'users';
             $user_result=$wpdb->get_results("SELECT * FROM $user_table");
        ?>
        
        <form action="" method="post" class="upsent_plugin_form">
            <section class="section_form">
            <input type="text" name="nome_da_tarefa" id="name" placeholder="nome da tarefa">
            <textarea name="descrição" id="description" cols="20" rows="10" placeholder="descrição"></textarea>
            </section>
            
            <section class="section_form">
            <input type="text" name="coord_X" id="coord_x" placeholder="cordenada x">
            <input type="text" name="coord_y" id="coord_x" placeholder="cordenada y">
            <input type="text" name="endereço" id="address">
            <select name="estados" id="states">
                <option value="parado">parado</option>
                <option value="em_andamento">em andamento</option>
                <option value="completa">completo</option>
            </select>
                <select name="usuarios" id="users">
                    <option value="empty"></option>
                    <?php foreach($user_result as $usuario):?>
                    <option value="<?php echo esc_attr($usuario->user_login); ?>" <?php selected($usuario->user_login); ?>><?php echo esc_html($usuario->user_login); ?></option>
                    <?php endforeach;?>
                </select>
            </section>
         
            <input type="submit" value="Cadastrar" name="submit">
            
        </form>
        <?php 
            $nome = isset($_POST['nome_da_tarefa'])?$_POST['nome_da_tarefa']:'';
            $description = isset($_POST['descrição'])?$_POST['descrição']:'';
            $coord_x=isset($_POST['coord_X'])?$_POST['coord_X']:'';
            $coord_y=isset($_POST['coord_y'])?$_POST['coord_y']:'';
            $current_state=isset($_POST['estados'])?$_POST['estados']:'';
            $address=isset($_POST['endereço'])?$_POST['endereço']:'';
            $user_responseble=isset($_POST['usuarios'])?$_POST['usuarios']:'';


            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
                $table_name = $wpdb->prefix . 'my_tasks';
                $wpdb->insert(
                    $table_name,
                    array(
                        'task_name'=>$nome,
                        'creation_data'=> current_time('mysql'),
                        'task_description'=>$description,
                        'task_address'=>$address,
                        'coord_x'=>$coord_x,
                        'coord_y'=>$coord_y,
                        'states'=>$current_state,
                        'funcionaro_responsavel'=>$user_responseble,
                        )
                    );
                }


        ?>

        <ul>
            <li><?php echo $nome;?></li>
            <li><?php echo $description;?></li>
            <li><?php echo $coord_x;?></li>
            <li><?php echo $coord_y;?></li>
            <li><?php echo $current_state;?></li>
            <li><?php echo $address;?></li>
        </ul>
       
    </section>
    
</body>
</html>

