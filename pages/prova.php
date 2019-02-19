<?php require ( "../lib/connect.php" ) ; ?>
<?php session_start () ?>
<?php 
if ( !array_key_exists ( "s_login", $_SESSION ) ) {
	header ("Location: login.html?fail=true") ;
}
?>
<?php
conectar () ; 

if ( array_key_exists ( "prvcod", $_REQUEST ) ) {
  $query  = " select prv_nome, prv_ano, prv_semestre, prv_qtd_questao, " ; 
  $query .= " prv_crs_id, prv_pst_id, qst_dtprevelab, qst_dtprevrev, qst_dtprevconc " ; 
  $query .= " from Prova LEFT JOIN Questao ON prv_id = qst_prv_id " ; 
  $query .= " where prv_id = ".$_REQUEST["prvcod"] ;

  $result = mysql_query ( $query ) ;
  $provaret = mysql_fetch_object ( $result ) ; 
}
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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" >
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" rel="stylesheet" >

</head>

<body>
		
    <div id="wrapper">

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
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Criar/Alterar Prova</h1>
                </div>
            </div>
            <!-- /.row -->
			
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Formulário
                        </div>

						<form name="prova" method="POST" action="reg_prova.php">
							<?php
							if ( array_key_exists ( "prvcod", $_REQUEST ) ) {
							  echo '<input type=hidden name=prvcod value='.$_REQUEST["prvcod"].'> ' ; 
							}
							?>
                        <div class="panel-body">
                            <div class="col">
								<div class="row">
									<div class="col-lg-6">
										<label>Descrição:</label>
										<input type="text" name="descr" value="<?php echo $provaret->prv_nome ?>" class="form-control">
									</div>
									<div class="col-lg-6">
										<label>Curso:</label>
										<select name="curso" class="form-control">
										<?php 
											echo "<OPTION VALUE=0> </OPTION> " ;
											$query  = "SELECT crs_id, crs_nome from Curso " ; 
											$query .= " WHERE crs_clb_id = " .$_SESSION["s_logid"] ;   
											$query .= " ORDER BY crs_nome ; " ;
  											$result = mysql_query ($query) ;

											while ( $curso = mysql_fetch_object ($result) ) {	
												echo "<OPTION VALUE=".$curso->crs_id ;
												if ( $provaret->prv_crs_id == $curso->crs_id ) {
													echo " selected " ;
												}
    										echo ">".utf8_encode($curso->crs_nome)."</OPTION> " ;
 											}
										?>
										</select>
									</div>
								</div>
								<div class="row top-buffer">
									<div class="col-lg-4">
										<label>Ano:</label>
										<input type="text" name="ano" value="<?php echo $provaret->prv_ano ?>" class="form-control">
									</div>
									<div class="col-lg-4">
										<label>Semestre:</label>
										<select name="semestre" class="form-control">
											<option value=1 <?php if ( $provaret->prv_semestre == '1' ) echo "selected" ?> >1</option>
    										<option value=2 <?php if ( $provaret->prv_semestre == '2' ) echo "selected" ?> >2</option>
										</select>
									</div>
									<div class="col-lg-4">
										<label>Quantidade de Questões:</label>
										<input type="text" name="qt_quest" value="<?php echo $provaret->prv_qtd_questao ?>" class="form-control">
									</div>
								</div>
								<div class="row top-buffer">
									<div class="col-lg-4">
										<label>Data limite para Elaboração da Questão:</label>
										<input type="date" name="dt_elab" value="<?php echo $provaret->qst_dtprevelab ?>" class="form-control">
									</div>
									<div class="col-lg-4">
										<label>Data limite para Revisão da Questão:</label>
										<input type="date" name="dt_rev" value="<?php echo $provaret->qst_dtprevrev ?>" class="form-control">
									</div>
									<div class="col-lg-4">	
										<label>Data limite para Conclusão da Questão:</label>
										<input type="date" name="dt_conc" value="<?php echo $provaret->qst_dtprevconc ?>" class="form-control">
									</div>
								</div>
                            </div>
							<input type="hidden" name="file" size=50 value="">
							<div class="col top-buffer">
								<button type="submit" value=Gravar class="btn btn-default">Gravar</button>
							</div>
                        </div>
							
						</form>
							
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Questões
                        </div>
                        <div class="panel-body">
							<!--<div class="table-responsive">-->
							<div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <!--<table class="table table-bordered table-striped">-->
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
									$queryq .= " grq_desc, stq_desc, tpq_desc, qst_prv_id " ;
									$queryq .= " FROM (( Prova INNER JOIN Questao ON prv_id = qst_prv_id ) LEFT JOIN Disciplina ON dsc_id = qst_dsc_id ) " ;
									$queryq .= " LEFT JOIN Conteudo ON ctd_id = qst_ctd_id LEFT JOIN Colaborador colp ON colp.clb_id = qst_pro_clb_id " ;
									$queryq .= " LEFT JOIN Colaborador colr ON colr.clb_id = qst_pro_clb_id LEFT JOIN GrauQuestao ON grq_id = qst_grq_id " ;
									$queryq .= " LEFT JOIN StatQuestao ON stq_id = qst_stq_id LEFT JOIN TipoQuestao ON tpq_id = qst_tpq_id " ; 
									$queryq .= " where qst_prv_id = ".$_REQUEST["prvcod"] ;
									$queryq .= " order by qst_ordem " ;
									$resultqst = mysql_query ($queryq) ; 
									
									if ($resultqst) {
										while ( $questrow = mysql_fetch_assoc ( $resultqst ) ) {
											echo "<tr>" ;	
											//Modal
                                            echo '<div class="bs-example">' ;
											echo '<td><div class="col-1"><a href="questpadrao.php?qstcod='.$questrow["qst_id"].'" data-toggle="modal" data-target="#myModal'.$questrow["qst_id"].'" data-id="'.$questrow["qst_id"].'" class="questaomodal"> Questão '.$questrow["qst_ordem"].'</a></div></td>' ;
											echo '<div id="myModal'.$questrow["qst_id"].'" tabindex="-1" class="modal fade">' ;
											echo '<div class="modal-dialog">' ;
											echo '<div class="modal-content">' ;
											echo '</div>' ;
											echo '</div>' ;
											echo '</div>' ;
                                            echo '</div>' ;
											//End Modal
											echo '<td><div class="col-2">' .utf8_encode($questrow[dsc_desc]). '</div></td>' ;
											echo '<td><div class="col-2">' .utf8_encode($questrow[ctd_desc]). '</div></td>' ;
											echo '<td><div class="col-2">' .utf8_encode($questrow[colp]). '</div></td>' ;
											echo '<td><div class="col-2">' .utf8_encode($questrow[colr]). '</div></td>' ;
											echo '<td><div class="col-1">' .utf8_encode($questrow[grq_desc]). '</div></td>' ;
											echo '<td><div class="col-1">' .utf8_encode($questrow[tpq_desc]). '</div></td>' ;
											echo '<td><div class="col-1">' .utf8_encode($questrow[stq_desc]). '</div></td>' ;
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
            </div>
        </div>
    </div>

    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>

</body>
</html>
