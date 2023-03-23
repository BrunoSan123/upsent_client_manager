<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suas Tarefas</title>
</head>
<body>

    <header>
        <nav><h1>Tarefas Cadastradas</h1></nav>
    </header>

    <section>
        <?php 
            global $wpdb;
            $current_user= wp_get_current_user();
            $table_name=$wpdb->prefix . 'my_tasks';
            $results=$wpdb->get_results("SELECT * FROM $table_name WHERE funcionaro_responsavel='$current_user->display_name'");
            $user_table=$wpdb->prefix.'users';
            $user_result=$wpdb->get_results("SELECT * FROM $user_table");
            $logs_table_name=$wpdb->prefix.'logs';
            
        ?>

        <?php $i=0;?>    
        <?php foreach($results as $result):?>
            <table class="upsent_table">
            <tr class="upsent_table_head">
                <th>Nome da Tarefa</th>
                <th>Enrereço da Tarefa</th>
                <th>Descrição da tarefa</th>
                <th>Cordenada X</th>
                <th>Coordenada Y</th>
                <th>Andamento</th>
                <th>Funcionário</th>
                <th></th>
            </tr>
            <tr class="upsent_table_data">
                <td><?php echo $result->task_name?></td>
                <td><?php echo $result->task_address?></td>
                <td><?php echo $result->task_description?></td>
                <td><?php echo $result->coord_x?></td>
                <td><?php echo $result->coord_y?></td>
                <td><?php echo $result->states?></td>
                <td><?php echo $result->funcionaro_responsavel?></td>
                <td><button class="change_btn">alterar</button></td>
            </tr>
            
        </table>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChwlr0dGv_YSZfJkVdblKgIV47MK3tkks&callback=initMap"></script>
        <div id="map"></div>
        <div id="demo"></div>
            <?php $i++;?>
        <?php endforeach;?>
    </section>

    <?php $i=0;?>
    <?php foreach($results as $result):?>
        
        <div class="upsent-pop-up" id="upsent-<?php echo $i?>">
          <section>
        <form action="" method="post" class="upsent_plugin_form">
            <section class="section_form">
            <select name="estados-<?php echo $i?>" id="states">
                    <option value="parado" <?php selected($result->states, 'parado'); ?>>parado</option>
                    <option value="em_andamento" <?php selected($result->states, 'em_andamento'); ?>>em andamento</option>
                    <option value="completa" <?php selected($result->states, 'completa'); ?>>completo</option>
            </select>

            </section>
         
            <input type="submit" value="Atualizar" name="submit-<?php echo $i?>">
        </form>

        <?php

              $current_state=isset($_POST['estados-'.$i])?$_POST['estados-'.$i]:'';
              $sinal;
              if($current_state=='parado'){
                $sinal='RED';
              }elseif($current_state=='em_andamento'){
                $sinal='YELLOW';
              }else{
                $sinal= 'GREEN';
              }
              echo $sinal;

             
              if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-'.$i])){
             
                $wpdb->update(
                    $table_name,
                    array(
                        'states'=>$current_state,
                    ),
                    array(
                        'id'=>$result->id
                    )
                    );

                    $wpdb->insert(
                        $logs_table_name,
                        array(
                          'user'=>$result->funcionaro_responsavel,
                          'log_description'=>"usuario ".$result->funcionaro_responsavel." mudou o estado da tarefa para ".$current_state,
                          'sign'=>$sinal
                          )
                        );
                    }
            ?>
    
    </section> 
    <button class="upsent_close_button">X</button> 
    </div>
     <?php $i++;?>
    <?php endforeach;?>
    
</body>
</html>