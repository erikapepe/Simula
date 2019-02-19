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
                    <h1 class="page-header">Visualizar Provas</h1>
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
									<div class="col-lg-4">
										<label>Descrição:</label>
										<input type="text" name="descr" value="<?php echo $_REQUEST["descr"] ?>" class="form-control">
									</div>
									<div class="col-lg-4">
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
												if ( $_REQUEST["curso"] == $curso->crs_id ) {
													echo " selected " ;
												}
    										echo ">".utf8_encode($curso->crs_nome)."</OPTION> " ;
 											}
										?>
										</select>
									</div>
									<div class="col-lg-4">
										<label>Ano:</label>
										<input type="text" name="ano" value="<?php echo $_REQUEST["ano"] ?>" class="form-control">
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
                            Provas
                        </div>
                        <div class="panel-body">
							<div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
											<th><div class="col-xs-6 col-sm-3">Descrição</div></th>
											<th><div class="col-xs-6 col-sm-3">Curso</div></th>
											<th><div class="col-xs-6 col-sm-3">Ano/Semestre</div></th>
											<th><div class="col-xs-6 col-sm-3">Status</div></th>
											<th><div class="col-xs-6 col-sm-3">Ações</div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$queryp  = " select prv_id, prv_nome, prv_ano, prv_semestre, prv_qtd_questao, " ; 
									$queryp .= " prv_crs_id, prv_pst_id, crs_nome, pst_desc from Prova, Curso, ProvaStatus " ; 
									$queryp .= " where crs_id = prv_crs_id and prv_pst_id = pst_id and crs_clb_id = ".$_SESSION["s_logid"] ;

									if ( $_REQUEST["descr"] != "" ) {
										$queryp .= " and ( prv_nome like '%".$_REQUEST["descr"]."%' ) " ; 
									}

									if ( $_REQUEST["curso"] != 0 ) {
										$queryp .= " and ( prv_crs_id = ".$_REQUEST["curso"]." ) " ; 
									}

									if ( $_REQUEST["ano"] != null && $_REQUEST["ano"] != 0 ) {
										$queryp .= " and ( prv_ano = ".$_REQUEST["ano"]." ) " ;
									}
  									
									$resultprv = mysql_query ($queryp) ; 
									
									if ($resultprv) {
										while ( $provarow = mysql_fetch_row ( $resultprv ) ) {
											echo "<tr>" ;
											echo "<td><a href='prova.php?prvcod=" .$provarow[0]. "'>" .$provarow[1]. "</a></td>" ;
											echo "<td>" .utf8_encode($provarow[7]). "</td>" ;
											echo "<td>" .$provarow[2]. "." .$provarow[3]. "</td>" ;
											echo "<td>" .$provarow[8]. "</td>" ;
											echo "<td style='text-align: center'><a href='impressao.php?prvcod=" .$provarow[0]. "'><i class='fa fa-print'></i></td>" ;
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
