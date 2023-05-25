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
        <nav>
            <h1>Atividades Cadastradas</h1>
        </nav>
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
            </div>
        </form>

        <form action="" method="post">
            <div class="filter-div">
                <label for="filter_selection">Filtrar por estados</label>
                <select name="filter_selection" id="filter" class="filter">
                    <option value="" class="filter-item" selected></option>
                    <option value="parado" class="filter-item">parado</option>
                    <option value="em_andamento" class="filter-item">em andamaneto</option>
                    <option value="concluido" class="filter-item">concluido</option>
                </select>
                <input type="submit" value="filtrar estados" name='filtro'>

            </div>

        </form>
    </div>


    <section>


        <?php
        global $wpdb;
        $itens_por_pagina = 10;
        isset($_GET['pagina']) ? $pagina_atual = $_GET['pagina'] : $pagina_atual = 1;
        isset($_POST['filter_selection']) ? $filter = $_POST['filter_selection'] : '';
        $posicao_inicial = ($pagina_atual - 1) * $itens_por_pagina;
        $table_name = $wpdb->prefix . 'my_tasks';
        $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC LIMIT $posicao_inicial, $itens_por_pagina");
        $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        $total_pages = ceil($total_tasks / $itens_por_pagina);
        $user_table = $wpdb->prefix . 'users';
        $user_result = $wpdb->get_results("SELECT * FROM $user_table");
        $emplyer_report = $wpdb->prefix . 'employer_report';
        $state = null;
        $user_param=null;
        $company_param=null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_filter'])) {
            $results = null;
            $total_tasks = null;
            $total_pages = null;
            $user_param = $_POST['user_filter'];
            $results = $wpdb->get_results("SELECT * FROM $table_name WHERE funcionaro_responsavel='$user_param' ORDER BY id DESC LIMIT $posicao_inicial, $itens_por_pagina");
            $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE funcionaro_responsavel='$user_param'");
            $total_pages = ceil($total_tasks / $itens_por_pagina);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['company_filter'])) {
            $results = null;
            $total_tasks = null;
            $total_pages = null;
            $company_param = $_POST['company_filter'];
            $results = $wpdb->get_results("SELECT * FROM $table_name WHERE company='$company_param' ORDER BY id DESC LIMIT $posicao_inicial, $itens_por_pagina");
            $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE company='$company_param'");
            $total_pages = ceil($total_tasks / $itens_por_pagina);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filtro'])) {
            $results = null;
            $total_tasks = null;
            $total_pages = null;

            switch ($filter) {
                case 'parado':
                    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE states='$filter' ORDER BY id DESC LIMIT $posicao_inicial, $itens_por_pagina");
                    $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE states='$filter'");
                    $total_pages = ceil($total_tasks / $itens_por_pagina);
                    $state = $filter;
                    break;
                case 'em_andamento':
                    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE states='$filter' ORDER BY id DESC LIMIT $posicao_inicial, $itens_por_pagina");
                    $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE states='$filter'");
                    $total_pages = ceil($total_tasks / $itens_por_pagina);
                    $state = $filter;
                    break;
                case 'concluido':
                    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE states='completa' ORDER BY id DESC LIMIT $posicao_inicial, $itens_por_pagina");
                    $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE states='completa'");
                    $total_pages = ceil($total_tasks / $itens_por_pagina);
                    $state = $filter;
                    break;
                case '':
                    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC LIMIT $posicao_inicial, $itens_por_pagina");
                    $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
                    $total_pages = ceil($total_tasks / $itens_por_pagina);
                    break;
            }
        }


        ?>
        <input type="hidden" name="filtro" class="filter_selection" value="" data-target="<?php echo $state ?>">

        <?php foreach ($results as $result) : ?>
            <input type="hidden" name="concluido" class="conclued" data-target="<?php echo $result->concluida ?>">
            <input type="hidden" name="concluido" class="conclued-mobile" data-target="<?php echo $result->concluida ?>">

            <table class="upsent_table table-desk">
                <tr class="upsent_table_head">
                    <th>N° do Chamado</th>
                    <th>Endereço do Cliente</th>
                    <th>Escopo</th>
                    <th>Status</th>
                    <th>Técnico</th>
                    <?php if ($result->concluida != 0) : ?>
                        <th>Descrição do tecnico</th>
                    <?php endif ?>
                    <th>posição atual</th>
                    <th></th>
                    <th>Status</th>
                    <?php if ($result->concluida != 0) : ?>
                        <th>Comprovante</th>
                    <?php endif ?>
                    <th>Excluir</th>

                </tr>
                <tr class="upsent_table_data">
                    <td><?php echo $result->task_name ?></td>
                    <td><?php echo $result->task_address ?></td>
                    <td><a class="description button">Escopo</a></td>
                    <td><?php echo $result->states ?></td>
                    <td><?php echo $result->funcionaro_responsavel ?></td>
                    <td class="client-description"><a class="button">Abrir</a></td>
                    <td><a class="employee_position">Ver posição atual</a></td>
                    <td><button class="change_btn button">alterar</button></td>
                    <td>
                        <div class="<?php if ($result->states == "parado") : ?> conclued_bullet <?php elseif ($result->states == 'em_andamento') : ?>bullet-yellow<?php else : ?> bullet-green <?php endif ?>"></div>
                    </td>
                    <td class="comprovante comp_img">Abrir Galeria</td>
                    <td>
                        <div class="delete_task"></div>
                    </td>
                </tr>

            </table>

            <div class="upsent_table-mobile table-mobile">
                <div class="table_mobile_main">
                    <div class="upsent-table-item"><span>N° do chamado:</span><span><?php echo $result->task_name ?></span></div>
                    <div class="upsent-table-item"><span>Endereço do Cliente:</span><span><?php echo $result->task_address ?></span></div>
                    <div class="upsent-table-item"><span>Escopo da atividade:</span><span class="descriptionMobile  button"><a>Descrição</a></span></div>
                    <div class="upsent-table-item descriptionMobileEmployer"><span>Descrição do tecnico:</span><span class="button">Abrir</span></div>
                    <div class="upsent-table-item"><span>Status:</span><span><?php echo $result->states ?></span></div>
                    <div class="upsent-table-item"><span>tecnico:</span> <span><?php echo $result->funcionaro_responsavel ?></span> </div>
                    <div class="upsent-table-item"><span>posição atual:</span><a class="employee_position_mobile">Ver posição atual</a></div>

                    <div class="comprovanteMobile">
                        <div>Comprovante:</div>
                        <div class="comp_img">Abrir</div>
                    </div>
                    <div class="upsent-table-item"><span>Concluida:</span>
                        <div class="<?php if ($result->states == "parado") : ?> conclued_bullet<?php elseif ($result->states == "em_andamento") : ?>bullet-yellow<?php else : ?> bullet-green <?php endif ?>"></div>
                    </div>
                    <div class="upsent-table-item">Excluir:<div class="delete_task_mobile"></div>
                    </div>
                    <div class="upsent-table-item"><button class="change_btn_mobile button">alterar</button></div>
                </div>
            </div>

        <?php endforeach; ?>
    </section>

<?php
echo "<div class='pagination-upsent'>";

// Inclua os parâmetros dos filtros na URL dos links de paginação
$filterParams = "&user=" . $user_param . "&company=" .$company_param."&state=".$state;

if ($pagina_atual > 1) {
    echo "<a href='?page=tarefas&pagina=" . ($pagina_atual - 1) . $filterParams . "'>Anterior</a>";
}

for ($j = 1; $j <= $total_pages; $j++) {
    if ($j == $pagina_atual) {
        echo "<span class='current'>$j</span>";
    } else {
        echo "<a href='?page=tarefas&pagina=$j" . $filterParams . "'>$j</a>";
    }
}

if ($pagina_atual < $total_pages) {
    echo "<a href='?page=tarefas&pagina=" . ($pagina_atual + 1) . $filterParams . "'>Próximo</a>";
}

echo "</div>";
?>


    <?php $i = 0; ?>
    <?php
    $maped = [];
    $img_path = [];
    foreach ($results as $resulte) :
        $emp_report = $wpdb->get_results("SELECT * FROM $emplyer_report WHERE task_id=$resulte->id")
    ?>

        <div class="upsent-pop-up" id="upsent-<?php echo $i ?>">
            <section>
                <form action="" method="post" class="upsent-main">
                    <div class="upsent_plugin_form">
                        <section class="section_form">
                            <input type="text" name="nome_da_tarefa-<?php echo $i ?>" id="name-<?php echo $i ?>" placeholder="nome da tarefa" value="<?php echo esc_attr($resulte->task_name) ?>">
                            <input type="text" name="nome_da_empresa-<?php echo $i ?>" id="company_name" placeholder="Nome da Empresa" value="<?php echo esc_attr($resulte->company) ?>">
                            <textarea name="descrição-<?php echo $i ?>" id="description" cols="20" rows="10" placeholder="descrição"><?php echo esc_html($resulte->task_description) ?></textarea>
                        </section>

                        <section class="section_form">
                            <input type="text" name="coord_X-<?php echo $i ?>" id="coord_x" placeholder="cordenada x" value="<?php echo esc_attr($resulte->coord_x) ?>">
                            <input type="text" name="coord_y-<?php echo $i ?>" id="coord_y" placeholder="cordenada y" value="<?php echo esc_attr($resulte->coord_y) ?>">
                            <input type="text" name="endereço-<?php echo $i ?>" id="address" value="<?php echo esc_attr($resulte->task_address) ?>">
                            <select name="estados-<?php echo $i ?>" id="states">
                                <option value="parado" <?php selected($resulte->states, 'parado'); ?>>parado</option>
                                <option value="em_andamento" <?php selected($resulte->states, 'em_andamento'); ?>>em andamento</option>
                                <option value="completa" <?php selected($resulte->states, 'completa'); ?>>completo</option>
                            </select>
                            <select name="usuarios-<?php echo $i ?>" id="users">
                                <option value="empty" <?php selected($resulte->funcionaro_responsavel, ''); ?>></option>
                                <?php foreach ($user_result as $usuario) : ?>
                                    <option value="<?php echo esc_attr($usuario->user_login); ?>" <?php selected($resulte->funcionaro_responsavel, $usuario->user_login); ?>><?php echo esc_html($usuario->user_login); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </section>
                    </div>
                    <div class="buttons_container" style="padding-top: 2%;">
                        <div class="report_button button_upsent" style="display:inline-block;">Atualizar Relatório</div>
                        <input type="submit" value="Atualizar" name="submit-<?php echo $i ?>" class="button_upsent">
                    </div>
                </form>

                <?php
                $nome = isset($_POST['nome_da_tarefa-' . $i]) ? $_POST['nome_da_tarefa-' . $i] : '';
                $description = isset($_POST['descrição-' . $i]) ? $_POST['descrição-' . $i] : '';
                $coord_x = isset($_POST['coord_X-' . $i]) ? $_POST['coord_X-' . $i] : '';
                $coord_y = isset($_POST['coord_y-' . $i]) ? $_POST['coord_y-' . $i] : '';
                $current_state = isset($_POST['estados-' . $i]) ? $_POST['estados-' . $i] : '';
                $address = isset($_POST['endereço-' . $i]) ? $_POST['endereço-' . $i] : '';
                $user_responseble = isset($_POST['usuarios-' . $i]) ? $_POST['usuarios-' . $i] : '';
                $company = isset($_POST['nome_da_empresa-' . $i]) ? $_POST['nome_da_empresa-' . $i] : '';


                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-' . $i])) {
                    $budget_value = $_COOKIE['descritivo_ortcamento'];
                    $project = $_COOKIE['projeto'];
                    $incoming_value = $_COOKIE['valor_a_receber'];
                    $aditional_value = $_COOKIE['valor_adicional'];
                    $km = $_COOKIE['km'];
                    $km_value = $_COOKIE['valor_km'];
                    $aditional_coust = $_COOKIE['custo_adicional'];
                    $budget_value = $_COOKIE['valor-orcamento'];
                    $task_date_value = $_COOKIE['data_da_atividade'];
                    $city = $_COOKIE['cidade'];
                    $uf = $_COOKIE['uf'];
                    $aprovement_responseble = $_COOKIE['aprovacao_responsavel'];
                    $budget_describe = $_COOKIE['orcamento_descricao'];
                    $solution_observation = $_COOKIE['observacao_solution'];
                    $featured_value = $_COOKIE['valor_faturado'];
                    $budget_state = $_COOKIE['orcamento_status'];
                    $incoming_km_value=$_COOKIE['valor_km_rcv'];
                    echo $solution_observation;
                    echo $featured_value;
                    echo $budget_state;
                    $wpdb->update(
                        $table_name,
                        array(
                            'task_name' => $nome,
                            'task_description' => $description,
                            'task_address' => $address,
                            'coord_x' => $coord_x,
                            'coord_y' => $coord_y,
                            'states' => $current_state,
                            'funcionaro_responsavel' => $user_responseble,
                            'company' => $company
                        ),
                        array(
                            'id' => $resulte->id
                        )
                    );



                    $wpdb->update(
                        $emplyer_report,
                        array(
                            'value_budget' => $budget_value,
                            'project' => $project,
                            'incoming_value' => $incoming_value,
                            'aditional_cousts' => $aditional_coust,
                            'value_budget' => $budget_value,
                            'date_' => $task_date_value,
                            'city' => $city,
                            'uf' => $uf,
                            'aprovement_responseble' => $aprovement_responseble,
                            'budget_describe' => $budget_describe,
                            'solution_observation' => $solution_observation,
                            'employer_featured_value' => $featured_value,
                            'status_budget' => $budget_state,
                            'km'=>$km,
                            'value_km'=>$km_value,
                            'incoming_value_per_km '=>$incoming_km_value

                        ),
                        array(
                            'task_id' => $resulte->id
                        )
                    );
                }

                ?>

            </section>
            <button class="upsent_close_button">X</button>
        </div>
        <div class="map_modal">
            <div class="map"></div>
            <button class="upsent_close_button_map">X</button>
        </div>
        <div class="description-pop">
            <div class="text-description ">
                <p><?php echo $resulte->task_description ?></p>
            </div>
            <button class="upsent_close_button_description">X</button>
        </div>


        <div class="upsent-pop-up-desc" id="upsent-<?php echo $i ?>">
            <section class="section_form">
                <input type="text" name="valor_orçamento" class="valor_orçamento" id="orçamento" placeholder="orçamento" value="<?php echo $emp_report[0]->value_budget ?>">
                <input type="text" name="projeto" class="projeto" id="project" placeholder="projeto" value="<?php echo $emp_report[0]->project ?>">
                <input type="text" name="valor_receber" class="valor_receber" id="valor_receber" placeholder="valor a receber" value="<?php echo $emp_report[0]->incoming_value ?>">
                <input type="text" name="valor_adicional" class="valor_adicional" id="valor_adicional" placeholder="valor adicional" value="<?php echo $emp_report[0]->aditional_value_per_hour ?>">
                <input type="text" name="km" class="km" id="km" placeholder="km" value="<?php echo $emp_report[0]->km ?>">
                <input type="text" name="valor_em_km_rcv" class="valor_em_km_rcv" id="valor_em_km_rcv" placeholder="valor em KM a receber" value="<?php echo $emp_report[0]->incoming_value_per_km ?>">
                <input type="text" name="valor_em_km" class="valor_em_km" id="valor_em_km" placeholder="valor em KM" value="<?php echo $emp_report[0]->value_km ?>">
                <input type="text" name="custos_adicionais" class="custos_adicionais" id="custos_adicionais" placeholder="Custos adicionais" value="<?php echo $emp_report[0]->aditional_cousts ?>">
                <input type="text" name="valor_orcamento" class="valor_orcamento" id="valor_orcamento" placeholder="Valor do Orçamento" value="<?php echo $emp_report[0]->value_budget ?>">
                <input type="date" name="data_da_atividade" class="data_da_atividade" id="data_da_atividade" value="<?php echo $emp_report[0]->date_ ?>">
                <input type="text" name="cidade" id="cidade" class="cidade" placeholder="cidade" value="<?php echo $emp_report[0]->city ?>">
                <input type="text" name="uf" class="uf" id="uf" placeholder="UF" value="<?php echo $emp_report[0]->uf ?>">
                <input type="text" name="responsavel_aprovacao" class="responsavel_aprovacao" id="approvement" placeholder="Responsavel pela aprovação" value="<?php echo $emp_report[0]->aprovement_responseble ?>">
                <input type="text" name="descricao_orcamento" class="descricao_orcamento" id="descicao_orcamento" placeholder="Descrição do orçamento" value="<?php echo $emp_report[0]->budget_describe ?>">
                <input class="solution-observation" type="text" name="observacao" placeholder="Observação da solution" value="<?php echo $emp_report[0]->solution_observation ?>">
                <input class="valor_faturado" type="text" name="valor_faturado" placeholder="Valor já faturado" value="<?php echo $emp_report[0]->employer_featured_value ?>">
                <select name="status_orcamento" id="status_orcamento" class="budget_state">
                    <option value="aguardando" selected>Aguardando</option>
                    <option value="recusado">Recusado</option>
                    <option value="Aprovado">Aprovado</option>
                </select>
            </section>
            <button class="upsent_close_button-desc">X</button>
        </div>
        <div class="description-pop-employer">
            <div class="text-description ">
                <h4>Solução aplicada</h4>
                <p><?php echo $emp_report[0]->call_descritive ?></p>
                <h4>Observação do cliente</h4>
                <p><?php echo $emp_report[0]->client_observation ?></p>
            </div>
            <button class="upsent_close_button_employer_desc">X</button>
        </div>
        <?php if ($resulte->concluida != 0) : ?>
            <?php $arr = json_decode($resulte->conclued_img); ?>

            <div class="img_comprovante">
                <div class="work_proof_container">
                    <?php foreach ($arr as $image_result) : ?>
                        <div>
                            <a href="<?php echo PLUGIN_URL . "/uploads/" . $image_result->image_name ?>" download>
                                <img src="<?php echo PLUGIN_URL . "/uploads/" . $image_result->image_name ?>" alt="description-img">
                            </a>
                        </div>
                    <?php endforeach ?>
                </div>
                <button class="upsent_close_button_img">X</button>

            </div>
            <?php else:?>
                <div class="img_comprovante">
                <button class="upsent_close_button_img">X</button>    
                </div>
                
        <?php endif ?>

        <?php $i++; ?>
    <?php
        $maped[] = $resulte->funcionaro_responsavel;
        $img_path[] = PLUGIN_URL . "/uploads/" . $resulte->conclued_img;
    endforeach; ?>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChwlr0dGv_YSZfJkVdblKgIV47MK3tkks&callback=initMap"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        const usuario_maped = <?php echo json_encode($maped) ?>
    </script>
    <script>
        const img_path = <?php echo json_encode($img_path) ?>
    </script>
    <script>
        const per_page = <?php echo $itens_por_pagina ?>
    </script>
    <script>
        const actual_page = <?php echo $pagina_atual ?>
    </script>
    <?php require_once PLUGIN_PATH . 'templates/partials/site_url.php'; ?>
</body>

</html>