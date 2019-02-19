<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$conexaodb = mysql_connect("mysql.tuy.com.br", "tuy09", "erikapp13") or DIE("Erro na conexão com o banco de dados. <br><br>");
;

mysql_select_db("tuy09") or DIE("Erro na seleção do BD. <br>");

$query = "SELECT qst_id, qst_ordem, qst_enunc, qst_perg, qst_tpq_id "
        . "FROM Questao "
        . "WHERE qst_prv_id = 32 "
        . "ORDER BY qst_ordem";

$resource_qst = mysql_query($query, $conexaodb);
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Simula</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.2.0/metisMenu.min.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
        <style>
            .qst-tpq-dsc hr { 
                margin: 40px 0px; 
                color: #000000;
            }
            .qst{
                margin: 40px 0px;
            }
            .qst p {
                margin: 10px;
            }
            .qst-enunciado {
                background-color: #F0F0F0;
                padding: 10px;
                border-radius: 7px;
            }
            .qst-enunciado-txt {
            }
            .qst-pergunta {
                font-weight: bold;
            }
            .qst-tpq-alt li{
                margin: 5px;
            }
            .qst-tpq-ass li {
                margin: 5px;
            }
            .qst-tpq-ass-alt li {
                margin: 5px;
            }
        </style>
    </head>
    <body data-pinterest-extension-installed="cr1.39.1" cz-shortcut-listen="true" class>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="../index.html"><b>Simula</b></a>
                </div>

                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Desconectar</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="provas.html"><i class="fa fa-edit fa-fw"></i> Provas<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li>
                                        <a href="prova.php">Criar Prova</a>
                                    </li>
                                    <li>
                                        <a href="listaprova.php">Visualizar Prova</a>
                                    </li>
                                </ul>
                            </li>                        
                            <li class="active">
                                <a href="#"><i class="fa fa-files-o fa-fw"></i> Questões<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse in">
                                    <li>
                                        <a href="listaquest.php" class="active">Visualizar Questões</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <div id="page-wrapper" style="min-height: 314px;">
                <div class="row"> 
                    <h1 class="page-header">
                        Visualizar Prova 
                        <a target="blank" href="impressao.php" style="font-size: 20; float:right;"> 
                            <i class="fa fa-print"></i> 
                        </a>
                    </h1>
                </div>
                <div class="row">
                    <?php include_once './prova.php'; ?>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.2.0/metisMenu.min.js" ></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>
    </body>
</html>
