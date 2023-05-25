<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logs</title>
</head>

<body>
  <div class="filters">
    <form action="" method="post">
      <div class="filter-div">
        <label for="user_filter">Filtrar por empresa</label>
        <input type="text" name="user_filter" id="user_filter" class="input-paddings-1">
        <input type="submit" value="filtrar usuario" name='user_filter_button' style="padding: 2% !important;">
      </div>
    </form>
  </div>
  <?php
  global $wpdb;
  isset($_GET['pagina']) ? $pagina_atual = $_GET['pagina'] : $pagina_atual = 1;
  $itens_por_pagina = 10;
  $employer = isset($_POST['user_filter']) ? $_POST['user_filter'] : '';
  $logs_table = $wpdb->prefix . "logs";
  $report_table = $wpdb->prefix . 'employer_report';
  $logs_table_result = $wpdb->get_results("SELECT * FROM $logs_table");
  $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $logs_table");
  $total_pages = ceil($total_tasks / $itens_por_pagina);
  $company_param=null;

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['company_filter'])) {
    $results = null;
    $total_tasks = null;
    $total_pages = null;
    $company_param = $_POST['company_filter'];
    $results = $wpdb->get_results("SELECT * FROM $logs_table WHERE user='$employer' LIMIT $posicao_inicial, $itens_por_pagina");
    $total_tasks = $wpdb->get_var("SELECT COUNT(*) FROM $logs_table WHERE user='$employer'");
    $total_pages = ceil($total_tasks / $itens_por_pagina);
  }
  ?>

  <?php foreach ($logs_table_result as $result) :
    $report = $wpdb->get_results("SELECT * FROM $report_table WHERE task_id=$result->task_id");
  ?>
    <h4 class="notice notice-warning upsent-log">
      <span><?php echo $result->id ?></span>
      <span><?php echo $result->task_name ?></span>
      <span><?php echo $result->log_description ?></span>
      <span><?php echo $result->states ?></span>
      <span>
        <div class="<?php if ($result->sign == "RED") : ?> conclued_bullet <?php elseif ($result->sign == "YELLOW") : ?>bullet-yellow<?php else : ?> bullet-green <?php endif ?>"></div>
      </span>
      <?php if ($result->sign == "GREEN") : ?>
        <span>Horário de inicio: <?php echo $report[0]->start_time ?></span>
        <span>Horário de conclusão: <?php echo $report[0]->end_time ?></span>
      <?php endif ?>
    </h4>
  <?php endforeach ?>

<?php
echo "<div class='pagination-upsent'>";

$filterParams = "&company=" . $company_param;

if ($pagina_atual > 1) {
    echo "<a href='?page=historico&pagina=" . ($pagina_atual - 1) . $filterParams . "'>Anterior</a>";
}

for ($j = 1; $j <= $total_pages; $j++) {
    if ($j == $pagina_atual) {
        echo "<span class='current'>$j</span>";
    } else {
        echo "<a href='?page=historico&pagina=$j" . $filterParams . "'>$j</a>";
    }
}

if ($pagina_atual < $total_pages) {
    echo "<a href='?page=historico&pagina=" . ($pagina_atual + 1) . $filterParams . "'>Próximo</a>";
}

echo "</div>";
?>

</body>

</html>