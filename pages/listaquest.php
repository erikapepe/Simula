<?php require ( "../lib/connect.php" ) ; ?>
<?php session_start () ?>
<?php 
if ( !array_key_exists ( "s_logid", $_SESSION ) ) {
	header ("Location: login.html?fail=true") ;
}
?>
<?php
conectar () ;
?>

<!DOCTYPE html>
<html lang="en">

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

<body>
		
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
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="prova.php">Criar Prova</a>
                                </li>
                                <li>
                                    <a href="listaprova.php">Visualizar Prova</a>
                                </li>
                            </ul>
                        </li>                        
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Questões<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="listaquest.php">Visualizar Questões</a>
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

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Visualizar Questões</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Filtro de Busca
                        </div>
						<form name="prova" method="POST" action="">
                        <div class="panel-body">
                            <div class="col">
								<div class="row">
									<div class="col-lg-3">
										<label>Prova:</label>
										<select name="prova" class="form-control">
										<?php 
											echo "<OPTION VALUE=0> </OPTION> " ;
											$query  = "SELECT prv_id, prv_nome, crs_abrev from Prova, Curso " ; 
											$query .= " WHERE prv_crs_id = crs_id and crs_clb_id = " .$_SESSION["s_logid"] ;   
											$query .= " ORDER BY crs_abrev ; " ;
  											$result = mysql_query ($query) ;

											while ( $prova = mysql_fetch_object ($result) ) {
												echo "<OPTION VALUE=".$prova->prv_id ;
												if ( $_REQUEST["prova"] == $prova->prv_id ) {
													echo " selected " ;
												}
    										echo ">".utf8_encode($prova->crs_abrev)." - ".($prova->prv_nome)."</OPTION> " ;
 											}
										?>
										</select>
									</div>
									<div class="col-lg-3">
										<label>Professor:</label>
										<input type="text" name="profes" value="<?php echo $_REQUEST["profes"] ?>" class="form-control">
									</div>
									<div class="col-lg-3">
										<label>Status:</label>
										<select name="status" class="form-control">
										<?php 
											echo "<OPTION VALUE=0> </OPTION> " ;
											$query  = "SELECT stq_id, stq_desc from StatQuestao " ;   
											$query .= " ORDER BY stq_desc ; " ;
  											$result = mysql_query ($query) ;

											while ( $status = mysql_fetch_object ($result) ) {
												echo "<OPTION VALUE=".$status->stq_id ;
												if ( $_REQUEST["status"] == $status->stq_id ) {
													echo " selected " ;
												}
    										echo ">".(utf8_encode($status->stq_desc))."</OPTION> " ;
 											}
										?>
										</select>
									</div>
									<div class="col-lg-3">
										<label>Tipo:</label>
										<select name="tipo" class="form-control">
										<?php 
											echo "<OPTION VALUE=0> </OPTION> " ;
											$query  = "SELECT tpq_id, tpq_desc from TipoQuestao " ; 
											$query .= " ORDER BY tpq_desc ; " ;
  											$result = mysql_query ($query) ;

											while ( $tipo = mysql_fetch_object ($result) ) {
												echo "<OPTION VALUE=".$tipo->tpq_id ;
												if ( $_REQUEST["tipo"] == $tipo->tpq_id ) {
													echo " selected " ;
												}
    										echo ">".(utf8_encode($tipo->tpq_desc))."</OPTION> " ;
 											}
										?>
										</select>
									</div>
								</div>
                            </div>
							<input type="hidden" name="file" size=50 value="">
							<div class="col top-buffer">
								<button type="submit" value=Gravar class="btn btn-default">Buscar</button>
							</div>
                        </div>
							
						</form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Questões
                        </div>
                        <div class="panel-body">
							<div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
											<th><div class="col-xs-6 col-sm-1">Ordem</div></th>
											<th><div class="col-xs-6 col-sm-2">Disciplina</div></th>
											<th><div class="col-xs-6 col-sm-2">Conteúdo</div></th>
											<th><div class="col-xs-6 col-sm-2">Responsável</div></th>
											<th><div class="col-xs-6 col-sm-2">Revisor</div></th>
											<th><div class="col-xs-6 col-md-1">Grau</div></th>
											<th><div class="col-xs-6 col-md-1">Tipo</div></th>
											<th><div class="col-xs-6 col-md-1">Status</div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
											
									$queryq  = " SELECT qst_id, qst_ordem, dsc_desc, ctd_desc, colp.clb_nome colp, colr.clb_nome colr, " ;
									$queryq .= " grq_desc, stq_desc, tpq_desc, qst_tpq_id, qst_prv_id " ;
									$queryq .= " FROM (( Prova INNER JOIN Questao ON prv_id = qst_prv_id ) LEFT JOIN Disciplina ON dsc_id = qst_dsc_id ) " ;
									$queryq .= " LEFT JOIN Conteudo ON ctd_id = qst_ctd_id LEFT JOIN Colaborador colp ON colp.clb_id = qst_pro_clb_id " ;
									$queryq .= " LEFT JOIN Colaborador colr ON colr.clb_id = qst_pro_clb_id LEFT JOIN GrauQuestao ON grq_id = qst_grq_id " ;
									$queryq .= " LEFT JOIN StatQuestao ON stq_id = qst_stq_id LEFT JOIN TipoQuestao ON tpq_id = qst_tpq_id " ;
									$queryq .= " WHERE prv_pst_id <> 4" ;

									if ( $_REQUEST["profes"] != "" ) {
										$queryq .= " and ( colp.clb_nome like '%".$_REQUEST["profes"]."%' ) " ; 
									}

									if ( $_REQUEST["prova"] != 0 ) {
										$queryq .= " and ( qst_prv_id = ".$_REQUEST["prova"]." ) " ; 
									}

									if ( $_REQUEST["status"] != 0 ) {
										$queryq .= " and ( qst_stq_id = ".$_REQUEST["status"]." ) " ;
									}

									if ( $_REQUEST["tipo"] != 0 ) {
										$queryq .= " and ( qst_tpq_id = ".$_REQUEST["tipo"]." ) " ;
									}

									if (($_REQUEST["profes"] != "") || ($_REQUEST["prova"] != 0) || ($_REQUEST["status"] != 0 ) || ($_REQUEST["tipo"] != 0 )) {
										$queryq .= "ORDER BY qst_ordem" ;
										$resultqst = mysql_query ($queryq) ;
									}
									
									if ($resultqst) {
										while ( $questrow = mysql_fetch_assoc ( $resultqst ) ) {
											
											switch ($questrow["qst_tpq_id"]) {
												
												case 1:
													$montaquest = "descquest.php";
													break;
												case 2:
													$montaquest = "asserquest.php";
													break;
												case 3:
													$montaquest = "objetquest.php";
													break;
												case 4:
													$montaquest = "compquest.php";
													break;
												default:
													$montaquest = "questpadrao.php";
													break;
											}
											
											echo "<tr>" ;
											echo '<td><div class="col-1"><a href="'.$montaquest.'?qstcod='.$questrow["qst_id"].'" data-toggle="modal" data-target="#myModalqst'.$questrow["qst_id"].'" data-id="'.$questrow["qst_id"].'" class="questaomodal"> Questão '.$questrow["qst_ordem"].'</a></div></td>' ;
											echo '<div id="myModalqst'.$questrow["qst_id"].'" tabindex="-1" class="modal fade">' ;
											echo '<div class="modal-dialog">' ;
											echo '<div class="modal-content">' ;
											echo '</div>' ;
											echo '</div>' ;
											echo '</div>' ;
                                            echo '</div>' ;
											//End Modal
											echo '<td><div class="col-2">' .utf8_encode($questrow["dsc_desc"]). '</div></td>' ;
											echo '<td><div class="col-2">' .utf8_encode($questrow["ctd_desc"]). '</div></td>' ;
											echo '<td><div class="col-2">' .utf8_encode($questrow["colp"]). '</div></td>' ;
											echo '<td><div class="col-2">' .utf8_encode($questrow["colr"]). '</div></td>' ;
											echo '<td><div class="col-1">' .utf8_encode($questrow["grq_desc"]). '</div></td>' ;
											echo '<td><div class="col-1">' .utf8_encode($questrow["tpq_desc"]). '</div></td>' ;
											echo '<td><div class="col-1">' .utf8_encode($questrow["stq_desc"]). '</div></td>' ;
											echo "</tr>" ;
										}
									}else{
										echo $queryp ;
									}
									?>
                                    </tbody>
                                </table>
                            </div>
						</div>
					</div>
                </div>
                <!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

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
