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
            $itens_por_pagina = 3;
            isset($_GET['pagina'])? $pagina_atual=$_GET['pagina']:$pagina_atual=1;
            $posicao_inicial = ($pagina_atual - 1) * $itens_por_pagina;
            $current_user= wp_get_current_user();
            $table_name=$wpdb->prefix . 'my_tasks';
            $results=$wpdb->get_results("SELECT * FROM $table_name WHERE funcionaro_responsavel='$current_user->display_name' LIMIT $posicao_inicial, $itens_por_pagina");
            $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE funcionaro_responsavel='$current_user->display_name'");
            $total_pages = ceil($total_tasks / $itens_por_pagina);
            $user_table=$wpdb->prefix.'users';
            $user_result=$wpdb->get_results("SELECT * FROM $user_table");
            $logs_table_name=$wpdb->prefix.'logs';
            $user_coords_table=$wpdb->prefix.'user_coords';
            ?>

            
        <?php foreach($results as $result):?>
            <?php $i=0;?>
            <table class="upsent_table">
            <tr class="upsent_table_head">
                <th>Nome da Tarefa</th>
                <th>Enrereço da Tarefa</th>
                <th>Descrição da tarefa</th>
                <th>Cordenada X</th>
                <th>Coordenada Y</th>
                <th>Andamento</th>
                <th>Funcionário</th>
                <th>Posição</th>
                <th></th>
                <th>Concluida</th>
                <?php if($result->concluida!=0):?>
                    <th>Comprovante</th>
                    <th>Entregar</th>
                <?php endif?>
            </tr>
            <tr class="upsent_table_data">
                <td><?php echo $result->task_name?></td>
                <td><?php echo $result->task_address?></td>
                <td><?php echo $result->task_description?></td>
                <td class="coord_x-<?php echo $i?>"><?php echo $result->coord_x?></td>
                <td class="coord_y-<?php echo $i?>"><?php echo $result->coord_y?></td>
                <td><?php echo $result->states?></td>
                <td><?php echo $result->funcionaro_responsavel?></td>
                <td><a class="client_position">Ver posição</a></td>
                <td><button class="change_btn">alterar</button></td>
                <td><div class="<?php if($result->concluida==0):?> conclued_bullet <?php else:?> bullet-green <?php endif?>"></div></td>
                <?php if($result->concluida!=0):?>
                    <td class="comprovante"><img src="<?php echo PLUGIN_URL."/uploads/".$result->conclued_img?>" alt="comprovante"></td>
                    <td><div class="finish"></div></td>
                <?php endif?>
            </tr>
            
        </table>
        <?php $i++?>

        <?php endforeach;?>
        
        <div id="demo"></div>
      </section>

      <?php
        echo "<div class='pagination-upsent'>";
        if ($pagina_atual > 1) {
            echo "<a href='?page=usuario&pagina=".($pagina_atual - 1)."'>Anterior</a>";
        }
        for ($j = 1; $j <= $total_pages; $j++) {
            if ($j == $pagina_atual) {
                echo "<span class='current'>$j</span>";
            } else {
                echo "<a href='?page=usuario&pagina=$j'>$j</a>";
            }
        }
        if ($pagina_atual < $total_pages) {
            echo "<a href='?page=usuario&pagina=".($pagina_atual + 1)."'>Próximo</a>";
        }
        echo "</div>";
      ?>

    <?php $i=0;?>
    <?php foreach($results as $result):?>
        
        <div class="upsent-pop-up" id="upsent-<?php echo $i?>">
          <section>
        <form action="" method="post" class="upsent_main" enctype="multipart/form-data">
            <div class=""upsent_plugin_form">
            <section class="section_form">
            <select name="estados-<?php echo $i?>" id="states-<?php echo $i?>" class="states">
                    <option value="parado" <?php selected($result->states, 'parado'); ?>>parado</option>
                    <option value="em_andamento" <?php selected($result->states, 'em_andamento'); ?>>em andamento</option>
                    <option value="completa" <?php selected($result->states, 'completa'); ?>>completo</option>
            </select>
            <input type="file" name="upload_file-<?php echo $i?>" id="picture_upload-<?php echo $i?>" value="Comprovante" class="upload_button">

            </section>
            </div>
         
            <input type="submit" value="Atualizar" name="submit-<?php echo $i?>" class="button">
        </form>


        <?php

             if(isset($_POST['estados-'.$i])){
                $current_state=isset($_POST['estados-'.$i])?$_POST['estados-'.$i]:'';
                $file=isset($_FILES['upload_file-'.$i])?$_FILES['upload_file-'.$i]:'';
                $sinal;
                $finished=0;
                $fileNew=explode('.',$file["name"]);
                echo $file["name"];
                $targetDirectory = PLUGIN_PATH.'/uploads/';
                $targetFile = $targetDirectory . basename($file["name"]);
                move_uploaded_file($file['tmp_name'],$targetFile);
                echo 'upload feito com sucesso';

                  
                switch($current_state){
                    case 'parado':
                        $sinal='RED';
                        break;
                    case 'em_andamento':
                        $sinal='YELLOW';
                        break;
                    case 'completa':
                        $sinal= 'GREEN';
                        $finished=1;
                        break;
                    default:
                        $sinal='';
                    }
            }


             
              if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-'.$i])){
                    $coord_x=$_COOKIE['coord_x'];
                    $coord_y=$_COOKIE['coord_y'];
                    $wpdb->update(
                    $table_name,
                    array(
                        'states'=>$current_state,
                        'concluida'=>$finished,
                        'conclued_img'=>$file["name"],
                        'employeer_position_x'=>$coord_x,
                        'employeer_position_Y'=>$coord_y,
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

                    $wpdb->insert(
                        $user_coords_table,
                        array(
                            'coord_x'=>$coord_x,
                            'coord_y'=>$coord_y,
                            'user'=>$result->funcionaro_responsavel
                        )
                    );
                    }
            ?>
    
    </section> 
    <button class="upsent_close_button">X</button> 
    </div>
    <div class="map_modal">
        <div class="map" ></div>
    <button class="upsent_close_button_map">X</button> 
    </div>
    <?php $i++;?>
    <?php endforeach;?>
    
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChwlr0dGv_YSZfJkVdblKgIV47MK3tkks&callback=initMap"></script>
    <script>
        const usuario ='<?php echo $current_user->display_name?>';
    </script>
    
</body>
</html>