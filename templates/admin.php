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
        <h1>Cadastro de Atividades</h1>
    </header>
  

    <section>
    <?php 
             global $wpdb;
             $user_table=$wpdb->prefix.'users';
             $user_result=$wpdb->get_results("SELECT * FROM $user_table");
             
        ?>
        
        <form action="" method="post" class="upsent_main">
            <div class="upsent_plugin_form">
            <section class="section_form" id="locate_state_form">
            <input type="text" name="nome_da_tarefa" id="name" placeholder="N° do chamado">
            <input type="text" name="nome_da_empresa" id="company_name" placeholder="Nome da Empresa">
            <input type="text" name="nome_do_cliente" id="client_name" placeholder="Nome do Cliente">
            <textarea name="descrição" id="description" cols="20" rows="7" placeholder="Escopo do chamado"></textarea>
            
           
            <!-- <input type="text" name="coord_X" id="coord_x" placeholder="cordenada x">
            <input type="text" name="coord_y" id="coord_x" placeholder="cordenada y"> -->
            <input type="text" name="endereço" id="address" placeholder="endereço: Rua Cidade Estado">
            <input type="text" name="cep_input" id="cep_field" placeholder="Digite o CEP" >
            <select name="estados" id="states">
                <option value="parado">Aguardando</option>
                <option value="em_andamento">Em atendimento</option>
                <option value="completa">Concluida</option>
            </select>
                <select name="usuarios" id="users">
                    <option disabled selected value="empty">Alocar técnico</option>
                    <?php foreach($user_result as $usuario):?>
                    <option value="<?php echo esc_attr($usuario->user_login); ?>" <?php selected($usuario->user_login); ?>><?php echo esc_html($usuario->user_login); ?></option>
                    <?php endforeach;?>
                </select>
            </section>
            
            <section class="section_form">
                <input type="text" name="valor_orçamento" id="orçamento" placeholder="orçamento">
                <input type="text" name="projeto" id="project" placeholder="projeto">
                <input type="text" name="valor_receber" id="valor_receber" placeholder="valor a receber">
                <input type="text" name="valor_adicional" id="valor_adicional" placeholder="valor adicional">
                <input type="text" name="km" id="km" placeholder="km">
                <input type="text" name="valor_em_km" id="valor_em_km" placeholder="valor em KM">
                <input type="text" name="custos_adicionais" id="custos_adicionais" placeholder="Custos adicionais">
                <input type="text" name="valor_orcamento" id="valor_orcamento" placeholder="Valor do Orçamento">
                <input type="date" name="data_da_atividade" id="data_da_atividade">
                <input type="text" name="cidade" id="cidade" placeholder="cidade">
                <input type="text" name="uf" id="uf" placeholder="UF">
                <input type="text" name="responsavel_aprovacao" id="approvement" placeholder="Responsavel pela aprovação">
                <input type="text" name="descricao_orcamento" id="descicao_orcamento" placeholder="Descrição do orçamento">

            </section>

            </div>
            
            <input type="submit" value="Cadastrar" name="submit" class="button_upsent button-left-10">  
        </form>
        
        <?php 
            $nome = isset($_POST['nome_da_tarefa'])?$_POST['nome_da_tarefa']:'';
            $description = isset($_POST['descrição'])?$_POST['descrição']:'';
            $coord_x=isset($_POST['coord_X'])?$_POST['coord_X']:'';
            $coord_y=isset($_POST['coord_y'])?$_POST['coord_y']:'';
            $current_state=isset($_POST['estados'])?$_POST['estados']:'';
            $address=isset($_POST['endereço'])?$_POST['endereço']:'';
            $user_responseble=isset($_POST['usuarios'])?$_POST['usuarios']:'';
            $company_name=isset($_POST['nome_da_empresa'])?$_POST['nome_da_empresa']:'';
            $cep=isset($_POST['cep_input'])?$_POST['cep_input']:'';
            $client=isset($_POST['nome_do_cliente'])?$_POST['nome_do_cliente']:'';
            $orcamento=isset($_POST['valor_orçamento'])?$_POST['valor_orçamento']:'';
            $projeto=isset($_POST['projeto'])?$_POST['projeto']:'';
            $valor_receber=isset($_POST['valor_receber'])?$_POST['valor_receber']:'';
            $valor_adicional=isset($_POST['valor_adicional'])?$_POST['valor_adicional']:'';
            $km=isset($_POST['km'])?$_POST['km']:'';
            $valor_em_km=isset($_POST['valor_em_km'])?$_POST['valor_em_km']:'';
            $custo_adicional=isset($_POST['custos_adicionais'])?$_POST['custos_adicionais']:'';
            $valor_orcamento=isset($_POST['valor_orcamento'])?$_POST['valor_orcamento']:'';
            $data=isset($_POST['data_da_atividade'])?$_POST['data_da_atividade']:'';
            $city=isset($_POST['cidade'])?$_POST['cidade']:'';
            $uf=isset($_POST['uf'])?$_POST['uf']:'';
            $approvment_responseble=isset($_POST['responsavel_aprovacao'])?$_POST['responsavel_aprovacao']:'';
            $budget_description=isset($_POST['descricao_orcamento'])?$_POST['descricao_orcamento']:'';



            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
               $table_name = $wpdb->prefix . 'my_tasks';
               $table_report=$wpdb->prefix. 'employer_report';
               $month=explode("-",$data);
               $dateobj=DateTime::createFromFormat('!m',$month[1]);
               $monthName=$dateobj->format('F');
               $realMonth=date_parse($monthName);
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
                        'company'=>$company_name,
                        'cep'=>$cep,
                        'client'=>$client
                        )
                    );
                $task_result=$wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC LIMIT 1");

                foreach($task_result as $task){
                    $wpdb->insert(
                        $table_report,
                        array(
                            'call_number'=>$nome,
                            'employer_name'=>$user_responseble,
                            'project'=>$projeto,
                            'incoming_value'=>floatval($valor_receber),
                            'aditional_value_per_hour'=>floatval($valor_adicional),
                            'km'=>floatval($km),
                            'incoming_value_per_km'=>floatval($valor_em_km),
                            'aditional_cousts'=>floatval($custo_adicional),
                            'date_'=>$data,
                            'value_budget'=>floatval($valor_orcamento),
                            'task_id'=>$task->id,
                            'company'=>$company_name,
                            'city'=>$city,
                            'uf'=>$uf,
                            'address_'=>$address,
                            'aprovement_responseble'=>$approvment_responseble,
                            'budget_describe'=>$budget_description,
                            'client'=>$client,
                            'month_'=>$realMonth['month']
                            )
                    );

                }

                    
                    ?>

                <div class="notice notice-warning">
                    <p>Cadastro realizado com sucesso</p>
                </div>
                <?php }?>
                
        


       
    </section>
    <?php require_once PLUGIN_PATH.'templates/partials/site_url.php';?>
</body>
</html>

