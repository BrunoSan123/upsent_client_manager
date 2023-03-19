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

    <div class="upsent-pop-up">
    <section>
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
                <?php foreach($user_result as $usuario):?>
                    <option value="<?php echo $usuario->user_login?>"><?php echo $usuario->user_login?></option>
                <?php endforeach;?>
             </select>
            </section>
         
            <input type="submit" value="Atualizar" name="submit">
            
        </form>
    
    </section>  
    </div>
</body>
</html>