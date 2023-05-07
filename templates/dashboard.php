<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
</head>
<body>
    <section class="dashboard">
     
        <?php
         global $wpdb;
         $table_name =$wpdb->prefix.'my_tasks';
         $results_finished=$wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE concluida=1");
         $results_incoming=$wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE states='em_andamento'");
         $results_stoped=$wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE states='parado'");
         //print_r(get_role('funcionario'));
        ?>
        <div class="dashboard_info dashboard_info_finished">Tarefas/funcionário concluidas: <p class="task_total"><?php echo $results_finished?></p></div>
        <div class="dashboard_info dashboard_info_incoming">Tarefas/funcionário em Andamento: <p class="task_total"><?php echo $results_incoming?></p></div>
        <div class="dashboard_info dashboard_info_stoped">Tarefas/funcionários a começar: <p class="task_total"><?php echo $results_stoped?></p></div>
    </section>
        <div>
            <canvas id="myChart"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
        
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'line',
            data: {
            labels: ['Tarefas concluidas','Tarefas em andamento','Tarefas a começar'],
            datasets: [{
                label: '# de tarefas',
                data: [<?php echo $results_finished?>,<?php echo $results_incoming?>,<?php echo $results_finished?>],
                borderWidth: 1
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });

    </script>
</body>
</html>