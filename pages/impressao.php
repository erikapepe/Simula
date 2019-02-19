<!DOCTYPE html>

<?php
$conexaodb = mysql_connect("mysql.tuy.com.br", "tuy09", "erikapp13") or DIE("Erro na conexão com o banco de dados. <br><br>");
;
mysql_select_db("tuy09") or DIE("Erro na seleção do BD. <br>");

$query = "SELECT qst_id, qst_ordem, qst_enunc, qst_perg, qst_tpq_id "
        . "FROM Questao "
	. "WHERE qst_prv_id = {$_REQUEST["prvcod"]} "
        . "ORDER BY qst_ordem";

$query_prv = "SELECT prv_nome "
        . "FROM Prova "
        . "WHERE prv_id = {$_REQUEST["prvcod"]}";

$resource_qst = mysql_query($query, $conexaodb);
$resource_prv = mysql_query($query_prv, $conexaodb);
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Simula</title>
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    	<link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
  		<link href="../dist/css/sb-admin-2.css" rel="stylesheet">
		<link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    </head>
    <body data-pinterest-extension-installed="cr1.39.1" cz-shortcut-listen="true" class>
        <div id="wrapper">

            <div id="page-wrapper" style="min-height: 314px; margin: 0px">
                <div class="row"> 
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php $result_prv = mysql_fetch_object($resource_prv); ?>
                            <?=$result_prv->prv_nome; ?>
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <?php include_once 'impprova.php'; ?>
                </div>
            </div>
        </div>
        <!-- jQuery -->
		<script src="../bower_components/jquery/dist/jquery.min.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

		<!-- Metis Menu Plugin JavaScript -->
		<script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

		<!-- Custom Theme JavaScript -->
		<script src="../dist/js/sb-admin-2.js"></script>
    </body>
</html>
