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
            <h1>Relatorios</h1>
        </nav>
    </header>
    <div class="">
        <form action="?xls_download" method="post" class="report">
            <div class="filter-div-x">
                <label for="employer_filter">Filtrar por usuario</label>
                <input type="text" name="employer_filter" id="employer_filter" class="input-paddings-1">
            </div>
            <div class="">
                <select name="meses" id="meses" class="filter">
                    <option value="January">Janeiro</option>
                    <option value="February">Fevereiro</option>
                    <option value="March">Março</option>
                    <option value="April">Abril</option>
                    <option value="May">Maio</option>
                    <option value="June">Junho</option>
                    <option value="July">Julho</option>
                    <option value="August">Agosto</option>
                    <option value="September">setembro</option>
                    <option value="October">Outubro</option>
                    <option value="November">Novembro</option>
                    <option value="December">Dezembro</option>
                </select>
            </div>
            <div>
                <label for="company">Filtar por empresa</label>
                <input type="text" name="company" id="company">
            </div>
            <div>
                <label for="task_date">Filtrar por data</label>
                <input type="date" name="task_date" id="task_date">
            </div>
            <input type="submit" value="Gerar Relatório" name="submit">
        </form>

    </div>
</body>

</html>