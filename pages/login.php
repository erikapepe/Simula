<?php require ( "../lib/connect.php" ) ; ?>
<?php session_start () ; ?>
<?php


$login = $_REQUEST["login"] ;
$senha = $_REQUEST["senha"] ;

$conexao = conectar () ; 

$query   = " select usr_id, usr_login, clb_nome, clb_mail, clb_fone, clb_pfl_id " ;
$query  .= " from Usuario, Colaborador where usr_id = clb_usr_id and " ;
$query  .= " usr_status = 'A' and usr_login = '$login' and usr_senha = '$senha' " ;

$result  = mysql_query( $query );

if ($result) {

	if ( mysql_num_rows ($result) > 0 ) {

	  $usuario = mysql_fetch_object ( $result ) ; 

	  $_SESSION["s_logid"] = $usuario->usr_id ;
	  $_SESSION["s_login"] = $usuario->usr_login ; 
	  $_SESSION["s_nome"] = $usuario->clb_nome ;  
	  $_SESSION["s_perfil"] = $usuario->clb_pfl_id ;
	  $_SESSION["s_mail"] = $usuario->clb_mail ;   
	  $_SESSION["s_fone"] = $usuario->clb_fone ;     

	  if ( $_SESSION["s_perfil"] == '1' ) {
		  header ("Location: listaprova.php" ) ; 
	  } else { 
		  header ("Location: listaquestp.php" ) ; 
	  }

	} else {
	  header ("Location: login.html?fail=true") ; 
	} 
	
}

?>