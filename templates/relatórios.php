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
        <form action="?xls_download" method="post" class="report">
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
</body>

</html>