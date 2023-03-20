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
        <nav><h1>Tarefas Cadastradas</h1></nav>
    </header>

    <section>
        <?php 
            global $wpdb;
            $table_name=$wpdb->prefix . 'my_tasks';
            $results=$wpdb->get_results("SELECT * FROM $table_name");
            $user_table=$wpdb->prefix.'users';
            $user_result=$wpdb->get_results("SELECT * FROM $user_table");
        ?>
            
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
           
        <?php endforeach;?>
    </section>

    <?php foreach($results as $resulte):?>
        <?php echo var_dump($resulte);?>
        <div class="upsent-pop-up">
            <section>
        <form action="" method="post" class="upsent_plugin_form">
            <section class="section_form">
            <input type="text" name="nome_da_tarefa" id="name" placeholder="nome da tarefa" value="<?php echo esc_attr($resulte->task_name)?>">
            <textarea name="descrição" id="description" cols="20" rows="10" placeholder="descrição"><?php echo esc_html($resulte->task_description)?></textarea>
            </section>
            
            <section class="section_form">
            <input type="text" name="coord_X" id="coord_x" placeholder="cordenada x" value="<?php echo esc_attr($resulte->coord_x)?>">
            <input type="text" name="coord_y" id="coord_y" placeholder="cordenada y" value="<?php echo esc_attr($resulte->coord_y)?>">
            <input type="text" name="endereço" id="address" value="<?php echo esc_attr($resulte->task_address)?>">
            <select name="estados" id="states">
                    <option value="parado" <?php selected($resulte->states, 'parado'); ?>>parado</option>
                    <option value="em_andamento" <?php selected($resulte->states, 'em_andamento'); ?>>em andamento</option>
                    <option value="completa" <?php selected($resulte->states, 'completa'); ?>>completo</option>
            </select>
             <select name="usuarios" id="users">
             <option value="empty" <?php selected($resulte->funcionaro_responsavel, ''); ?>></option>
                <?php foreach($user_result as $usuario):?>
                <option value="<?php echo esc_attr($usuario->user_login); ?>" <?php selected($resulte->funcionaro_responsavel, $usuario->user_login); ?>><?php echo esc_html($usuario->user_login); ?></option>
                <?php endforeach;?>
             </select>
            </section>
         
            <input type="submit" value="Atualizar" name="submit">
        </form>

        <?php
              $nome = isset($_POST['nome_da_tarefa'])?$_POST['nome_da_tarefa']:'';
              $description = isset($_POST['descrição'])?$_POST['descrição']:'';
              $coord_x=isset($_POST['coord_X'])?$_POST['coord_X']:'';
              $coord_y=isset($_POST['coord_y'])?$_POST['coord_y']:'';
              $current_state=isset($_POST['estados'])?$_POST['estados']:'';
              $address=isset($_POST['endereço'])?$_POST['endereço']:'';
              $user_responseble = isset($_POST['usuarios'])?$_POST['usuarios']:'';
              
              if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
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
    
    </section> 
    <button class="upsent_close_button">X</button> 
    </div>
    <?php endforeach;?>

    
</body>
</html>