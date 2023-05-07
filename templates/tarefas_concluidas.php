<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefas</title>
</head>
<body>
    <header>
        <nav><h1>Tarefas entregues</h1></nav>
    </header>

    <div class="filters">
        <form action="" method="post">
          <div class="filter-div">
            <label for="user_filter">Filtrar por Usuario</label>
            <input type="text" name="user_filter" id="user_filter" class="input-paddings-1">
            <input type="submit" value="filtrar usuario" name='user_filter_button' style="padding: 2% !important;">
          </div>
        </form>
        <form action="" method="post">
        <div class="filter-div">
            <label for="company_filter">Filtrar por empresa</label>
            <input type="text" name="company_filter" id="company_filter" class="input-paddings-1">
            <input type="submit" value="filtrar empresa" name='company_filter_button' style="padding: 2% !important;">
        </div >
        </form>
    </div>

    <section>


        <?php 
            global $wpdb;
            $itens_por_pagina = 10;
            isset($_GET['pagina'])? $pagina_atual=$_GET['pagina']:$pagina_atual=1;
            isset($_POST['filter_selection'])?$filter=$_POST['filter_selection']:'';
            $posicao_inicial = ($pagina_atual - 1) * $itens_por_pagina;
            $table_name=$wpdb->prefix . 'my_tasks';
            $results=$wpdb->get_results("SELECT * FROM $table_name WHERE entregue=1  LIMIT $posicao_inicial, $itens_por_pagina");
            $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE entregue=1");
            $total_pages = ceil($total_tasks / $itens_por_pagina);
            $user_table=$wpdb->prefix.'users';
            $user_result=$wpdb->get_results("SELECT * FROM $user_table");


            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['company_filter'])){
                $results=null;
                $total_tasks=null;
                $total_pages=null;
                $company_param=$_POST['company_filter'];
                $results=$wpdb->get_results("SELECT * FROM $table_name WHERE company='$company_param' AND entregue=1 LIMIT $posicao_inicial, $itens_por_pagina");
                $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE company='$company_param' AND entregue=1");
                $total_pages = ceil($total_tasks / $itens_por_pagina);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['company_filter'])){
                $results=null;
                $total_tasks=null;
                $total_pages=null;
                $company_param=$_POST['company_filter'];
                $results=$wpdb->get_results("SELECT * FROM $table_name WHERE company='$company_param' AND entregue=1 LIMIT $posicao_inicial, $itens_por_pagina");
                $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE company='$company_param' AND entregue=1");
                $total_pages = ceil($total_tasks / $itens_por_pagina);
            }


        ?>
        <?php foreach($results as $result):?>
           <table class="upsent_table table-desk">
            <tr class="upsent_table_head">
                <th>Nome da Tarefa</th>
                <th>Enrereço da Tarefa</th>
                <th>Descrição da tarefa</th>
                <th>Andamento</th>
                <th>Funcionário</th>
                <th></th>
                <th>Concluida</th>
                <?php if($result->entregue!=0):?>
                    <th>Reabrir</th>
                <?php endif?>
                <th>Excluir</th>

            </tr>
            <tr class="upsent_table_data">
                <td><?php echo $result->task_name?></td>
                <td><?php echo $result->task_address?></td>
                <td><a class="description">Descrição</a></td>
                <td><?php echo $result->states?></td>
                <td><?php echo $result->funcionaro_responsavel?></td>
                <td><button class="change_btn button">alterar</button></td>
                <td><div class="<?php if($result->concluida==0):?> conclued_bullet <?php else:?> bullet-green <?php endif?>"></div></td>
                <?php if($result->entregue!=0):?>
                    <td><div class="finish"></div></td>
                <?php endif?>
                <td><div class="delete_task"></div></td>
            </tr>
            
        </table>

        <div class="upsent_table-mobile table-mobile">
            <div class="table_mobile_main">
                <div class="upsent-table-item"><span>Nome da Tarefa:</span><span><?php echo $result->task_name?></span></div>
                <div class="upsent-table-item"><span>Enrereço da Tarefa:</span><span><?php echo $result->task_address?></span></div>
               <div class="upsent-table-item"><span>Andamento:</span><span><?php echo $result->states?></span></div>
                <div class="upsent-table-item"><span>Funcionário:</span> <span><?php echo $result->funcionaro_responsavel?></span> </div>
                <div class="upsent-table-item"><span>Concluida:</span><div class="<?php if($result->concluida==0):?> conclued_bullet <?php else:?> bullet-green <?php endif?>"></div></div>
                <?php if($result->concluida!=0):?>
                    <div class="upsent-table-item">Reabrir:<div class="finished"></div></div>
                    <div class="upsent-table-item">Excluir:<div class="delete_task_mobile"></div></div>
                    
                <?php endif?>
                <div class="upsent-table-item"><button class="change_btn_mobile button">alterar</button></div>
                </div>
            </div>

        <?php endforeach;?>
    </section>

    <?php
        echo "<div class='pagination-upsent'>";
        if ($pagina_atual > 1) {
            echo "<a href='?page=tarefas&pagina=".($pagina_atual - 1)."'>Anterior</a>";
        }
        for ($j = 1; $j <= $total_pages; $j++) {
            if ($j == $pagina_atual) {
                echo "<span class='current'>$j</span>";
            } else {
                echo "<a href='?page=tarefas&pagina=$j'>$j</a>";
            }
        }
        if ($pagina_atual < $total_pages) {
            echo "<a href='?page=tarefas&pagina=".($pagina_atual + 1)."'>Próximo</a>";
        }
        echo "</div>";
      ?>
        
    <?php $i=0;?>
    <?php 
    $maped=[];
    $img_path=[];
    foreach($results as $resulte):?>
        
        <div class="upsent-pop-up" id="upsent-<?php echo $i?>">
            <section>
        <form action="" method="post" class="upsent-main">
            <div class="upsent_plugin_form">
            <section class="section_form">
            <input type="text" name="nome_da_tarefa-<?php echo $i?>" id="name-<?php echo $i?>" placeholder="nome da tarefa" value="<?php echo esc_attr($resulte->task_name)?>">
            <textarea name="descrição-<?php echo $i?>" id="description" cols="20" rows="10" placeholder="descrição"><?php echo esc_html($resulte->task_description)?></textarea>
            </section>
            
            <section class="section_form">
            <input type="text" name="coord_X-<?php echo $i?>" id="coord_x" placeholder="cordenada x" value="<?php echo esc_attr($resulte->coord_x)?>">
            <input type="text" name="coord_y-<?php echo $i?>" id="coord_y" placeholder="cordenada y" value="<?php echo esc_attr($resulte->coord_y)?>">
            <input type="text" name="endereço-<?php echo $i?>" id="address" value="<?php echo esc_attr($resulte->task_address)?>">
            <select name="estados-<?php echo $i?>" id="states">
                    <option value="parado" <?php selected($resulte->states, 'parado'); ?>>parado</option>
                    <option value="em_andamento" <?php selected($resulte->states, 'em_andamento'); ?>>em andamento</option>
                    <option value="completa" <?php selected($resulte->states, 'completa'); ?>>completo</option>
            </select>
             <select name="usuarios-<?php echo $i?>" id="users">
             <option value="empty" <?php selected($resulte->funcionaro_responsavel, ''); ?>></option>
                <?php foreach($user_result as $usuario):?>
                <option value="<?php echo esc_attr($usuario->user_login); ?>" <?php selected($resulte->funcionaro_responsavel, $usuario->user_login); ?>><?php echo esc_html($usuario->user_login); ?></option>
                <?php endforeach;?>
             </select>
            </section>
             </div>
         
            <input type="submit" value="Atualizar" name="submit-<?php echo $i?>" class="button_upsent">
        </form>

        <?php
              $nome = isset($_POST['nome_da_tarefa-'.$i])?$_POST['nome_da_tarefa-'.$i]:'';
              $description = isset($_POST['descrição-'.$i])?$_POST['descrição-'.$i]:'';
              $coord_x=isset($_POST['coord_X-'.$i])?$_POST['coord_X-'.$i]:'';
              $coord_y=isset($_POST['coord_y-'.$i])?$_POST['coord_y-'.$i]:'';
              $current_state=isset($_POST['estados-'.$i])?$_POST['estados-'.$i]:'';
              $address=isset($_POST['endereço-'.$i])?$_POST['endereço-'.$i]:'';
              $user_responseble = isset($_POST['usuarios-'.$i])?$_POST['usuarios-'.$i]:'';
              
              if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-'.$i])){
                $wpdb->update(
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
                    ),
                    array(
                        'id'=>$resulte->id
                    )
                    );
              }
        
        ?>
      <button class="upsent_close_button">X</button>
    </section> 
     <?php $i++;?>
    <?php 
     $img_path[]= PLUGIN_URL."/uploads/".$resulte->conclued_img;  
    endforeach;?>
    <script>
        const per_page=<?php echo $itens_por_pagina?>
    </script>
    <script>
         const actual_page=<?php echo $pagina_atual?>
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php require_once PLUGIN_PATH.'templates/partials/site_url.php';?>
</body>
</html> 