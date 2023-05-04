<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
</head>

<body>
    <header>
        <nav>
            <h1>Atividade do funcionário</h1>
        </nav>
    </header>
    <div class="">
        <form action="" method="post" class="report">
            <div class="filter-div-x">
                <label for="employer_filter">Filtrar por usuario</label>
                <input type="text" name="employer_filter" id="employer_filter" class="input-paddings-1">
            </div>
            <div class="">
                <select name="meses" id="meses" class="filter">
                    <option value="janeiro">Janeiro</option>
                    <option value="fevereiro">Fevereiro</option>
                    <option value="marco">Março</option>
                    <option value="abril">Abril</option>
                    <option value="maio">Maio</option>
                    <option value="junho">Junho</option>
                    <option value="julho">Julho</option>
                    <option value="agosto">Agosto</option>
                    <option value="setembro">setembro</option>
                    <option value="outubro">Outubro</option>
                    <option value="novembro">Novembro</option>
                    <option value="dezembro">Dezembro</option>
                </select>
            </div>
            <input type="submit" value="Gerar Relatório" name="submit">
        </form>

    </div>



    <?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'employer_report';
    $employer = isset($_POST['employer_filter']) ? $_POST['employer_filter'] : '';
    $output = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['employer_filter'])) {
        $results = $wpdb->get_results("SELECT * FROM $table_name WHERE employer_name='$employer'");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

        $customers_data = array(array('customers_id' => '1', 'customers_firstname' => 'Chris', 'customers_lastname' => 'Cavagin', 'customers_email' => 'chriscavagin@gmail.com', 'customers_telephone' => '9911223388'), array('customers_id' => '2', 'customers_firstname' => 'Richard', 'customers_lastname' => 'Simmons', 'customers_email' => 'rsimmons@media.com', ' clientes_telefone' => '9911224455'), array('customers_id' => '3', 'customers_firstname' => 'Steve', 'customers_lastname' => 'Beaven', 'customers_email' => 'ateavebeaven@gmail.com', 'customers_telephone' => '8855223388'), array('customers_id' => '4', 'customers_firstname' => 'Howard', 'customers_lastname' => 'Rawson', 'customers_email' => 'howardraw@gmail. com', 'customers_telephone' => '9911334488'), array('customers_id' => '5', 'customers_firstname' => 'Rachel', 'customers_lastname' => 'Dyson', 'customers_email' => 'racheldyson@ gmail.com', 'customers_telephone' => '9912345388'));
        $output .= "
              <table>
              <th>custumer_id</th>
              <th>custumer_firstname</th>
            ";

        foreach ($customers_data as $costumer) {
            $output .= "
                    <tr>
                    <td>" . $costumer['customers_id'] . "</td>
                    <td>" . $costumer['customers_firstname'] . "</td>
                    </tr>
                ";

        }
        $output .= "</table>";
        header('Content-Type:application/xls');
        header('Content-Disposition:attachment=reports.xls');
        echo $output;

        exit;
    }

    ?>
</body>

</html>