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
            $results=$wpdb->get_results("SELECT * FROM $table_name WHERE funcionaro_responsavel='$current_user->user_nicename' AND entregue=0 LIMIT $posicao_inicial, $itens_por_pagina");
            $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE funcionaro_responsavel='$current_user->user_nicename' AND entregue=0");
            $total_pages = ceil($total_tasks / $itens_por_pagina);
            $user_table=$wpdb->prefix.'users';
            $user_result=$wpdb->get_results("SELECT * FROM $user_table");
            $logs_table_name=$wpdb->prefix.'logs';
            $user_coords_table=$wpdb->prefix.'user_coords';
            $task_image_table=$wpdb->prefix.'my_task_images';
            ?>

                    
        <?php foreach($results as $result):?>

            <input type="hidden" name="concluido" class="conclued" data-target="<?php echo $result->concluida?>">
            <?php $i=0;?>
            <table class="upsent_table table-desk">
            <tr class="upsent_table_head">
                <th>Nome da Tarefa</th>
                <th>Enrereço da Tarefa</th>
                <th>Descrição da tarefa</th>
                <th>Andamento</th>
                <th>Funcionário</th>
                <th>Posição</th>
                <th></th>
                <th>Concluida</th>
                <?php if($result->concluida!=0):?>
                    <th>Comprovante</th>
                <?php endif?>
                <th>Entregar</th>
            </tr>
            <tr class="upsent_table_data">
                <td><?php echo $result->task_name?></td>
                <td><?php echo $result->task_address?></td>
                <td><a class="description">Descrição</a></td>
                <td><?php echo $result->states?></td>
                <td><?php echo $result->funcionaro_responsavel?></td>
                <td><a class="client_position">Ver posição</a></td>
                <td><button class="change_btn button">alterar</button></td>
                <td><div class="<?php if($result->concluida==0):?> conclued_bullet <?php else:?> bullet-green <?php endif?>"></div></td>
                <td class="comprovante comp_img">Abrir Galeria</td>
                <td><div class="finish"></div></td>
            </tr>
            
        </table>

        <div class="upsent_table-mobile table-mobile">
            <div class="table_mobile_main">
                <div class="upsent-table-item"><span>Nome da Tarefa:</span><span><?php echo $result->task_name?></span></div>
                <div class="upsent-table-item"><span>Enrereço da Tarefa:</span><span><?php echo $result->task_address?></span></div>
                <div class="upsent-table-item descriptionMobile"><span>Descrição da tarefa:</span><span>Descrição</span></div>
               <div class="upsent-table-item"><span>Andamento:</span><span><?php echo $result->states?></span></div>
                <div class="upsent-table-item"><span>Funcionário:</span> <span><?php echo $result->funcionaro_responsavel?></span> </div>
                <div class="upsent-table-item"><span>posição atual:</span><a class="client_position_mobile">Ver posição atual</a></div>
                
                
                    <div class="comprovanteMobile">
                        <div>Comprovante: </div>
                        <div class="comp_img">Abrir</div>
                    </div>

                <div class="upsent-table-item"><span>Concluida:</span><div class="<?php if($result->concluida==0):?> conclued_bullet <?php else:?> bullet-green <?php endif?>"></div></div>
                <div class="upsent-table-item">Entregar:<div class="finished"></div></div>
                <div class="upsent-table-item"><button class="change_btn_mobile button">alterar</button></div>
                </div>
            </div>
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
            <section class="section_form flex">
            <select name="estados-<?php echo $i?>" id="states-<?php echo $i?>" class="states">
                    <option value="parado" <?php selected($result->states, 'parado'); ?>>parado</option>
                    <option value="em_andamento" <?php selected($result->states, 'em_andamento'); ?>>em andamento</option>
                    <option value="completa" <?php selected($result->states, 'completa'); ?>>completo</option>
            </select>
            <div class="upload_button">
                <label class="upload_Button_label" for="picture_upload-<?php echo $i?>">Enviar arquivo</label>
                <input type="file" name="upload_file-<?php echo $i?>[]" multiple  id="picture_upload-<?php echo $i?>">
            </div>
            </section>
            </div>
         
            <input type="submit" value="Atualizar" name="submit-<?php echo $i?>" class="button_upsent consumer_button">
        </form>


        <?php

             if(isset($_POST['estados-'.$i])){
                $current_state=$_POST['estados-'.$i];
                $sinal;
                $finished=0;

                //$fileNew=explode('.',$file["name"]);
                
                

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
                    }
                    echo $finished;
                    echo $sinal;
                }


             
              if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-'.$i])){
                if(isset($_FILES['upload_file-'.$i])){
                    $file=$_FILES['upload_file-'.$i];
                    foreach($file["tmp_name"] as $key=>$tmp_name){
                        $name=$file["name"][$key];
                        $targetDirectory = PLUGIN_PATH.'/uploads/';
                        $targetFile = $targetDirectory . basename($name);
                        move_uploaded_file($tmp_name,$targetFile);
                        $wpdb->insert(
                            $task_image_table,
                            array(
                                'nome'=>$name,
                                'task_id'=>$result->id
                            )
                        );
                    }
                    $task_image_results=$wpdb->get_results("SELECT * FROM $task_image_table WHERE task_id=$result->id");
                    $image_json=[];
                    foreach($task_image_results as $task_img){
                        $imagem=[
                            'id'=>$task_img->id,
                            'image_name'=>$task_img->nome,     
                        ];
                        $image_json[]=$imagem;
                    
                    }

                }
                    $coord_x=$_COOKIE['coord_x'];
                    $coord_y=$_COOKIE['coord_y'];
                    $task_images_json=json_encode($image_json);
                    $wpdb->update(
                    $table_name,
                    array(
                        'states'=>$current_state,
                        'concluida'=>$finished,
                        'employeer_position_x'=>$coord_x,
                        'conclued_img'=>$task_images_json,
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
                          'log_description'=>"usuario ".$result->funcionaro_responsavel." mudou o estado da tarefa para",
                          'task_name'=>$result->task_name,
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
    <div class="description-pop">
        <div class="text-description ">
            <p><?php echo $result->task_description?></p>
        </div>
        <button class="upsent_close_button_description">X</button>
     </div>
     <?php if($result->concluida!=0):?>
     <?php $arr =json_decode($result->conclued_img); ?>
    
     <div class="img_comprovante">
        <div class="work_proof_container">
        <?php foreach($arr as $image_result):?>
            <div>
            <img src="<?php echo PLUGIN_URL."/uploads/".$image_result->image_name ?>" alt="description-img">
            </div>
        <?php endforeach?>
        </div>
        <button class="upsent_close_button_img">X</button>
    </div>
   
    <?php endif?>
    <?php $i++;?>
    <?php endforeach;?>
    
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChwlr0dGv_YSZfJkVdblKgIV47MK3tkks&callback=initMap"></script>
    <script>
        const usuario ='<?php echo $current_user->user_nicename?>';
    </script>
    <?php require_once PLUGIN_PATH.'templates/partials/site_url.php';?>
    
</body>
</html>