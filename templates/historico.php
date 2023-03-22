<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
</head>
<body>
    <?php 
      global $wpdb;
      $logs_table=$wpdb->prefix."logs";
      $logs_table_result=$wpdb->get_results("SELECT * FROM $logs_table");
      ?>

      <?php foreach($logs_table_result as $result):?>
        <h4>
        <span><?php echo $result->id?></span>
        <span><?php echo $result->log_description?></span>
        <span><?php echo $result->sign?></span>
      </h4>
      <?php endforeach?>
    
</body>
</html>