<?php require ( "../lib/connect.php" ) ;

session_start () ;

if ( !array_key_exists ( "s_login", $_SESSION ) ) {
        exit ; 
}

conectar () ;

mysql_select_db ("tuy09") or DIE ("Erro na seleção do BD.<br>");

if ( !array_key_exists ( "prvcod", $_REQUEST ) ) {
	
  $prvcod  = contador("PRV") ;
  $data = date("Y-m-d H:i:s") ;
  $status = 1 ;
  $aux = 1 ;

  $query  = " INSERT INTO Prova ( prv_id, prv_nome, prv_ano, prv_semestre, prv_qtd_questao, prv_data, prv_crs_id, prv_pst_id ) " ; 
  $query .= " VALUES ( ".$prvcod.", '".$_REQUEST["descr"]."', ".$_REQUEST["ano"].", ".$_REQUEST["semestre"] ; 
  $query .= ", ".$_REQUEST["qt_quest"].", '".$data."', ".$_REQUEST["curso"].", ".$status." )" ;

} else {
	
  	$aux = 2 ;
  	$data = date("Y-m-d H:i:s") ;
	$qtqst = $_REQUEST["qt_quest"] ;
	$result = mysql_query ( "SELECT prv_qtd_questao FROM Prova WHERE prv_id = ".$_REQUEST["prvcod"]." ;" ) ; 
	
	if ($result) {
		$quant = mysql_fetch_object ( $result ) ;
		$qtqst_old = $quant->prv_qtd_questao ;
		
		if ( $qtqst > $qtqst_old ) {
			$ret = maisquest( $qtqst_old, $qtqst, $prvcod ) ;
		}else if ( $qtqst < $qtqst_old ) {
			$ret = menosquest( $qtqst_old, $qtqst, $prvcod ) ;
		}
	}
	
  	//$status = 1;
  	$query  = " UPDATE Prova SET " ; 
  	$query .= " prv_nome = '".$_REQUEST["descr"]."', " ;
  	$query .= " prv_ano = ".$_REQUEST["ano"].", " ;
  	$query .= " prv_semestre = ".$_REQUEST["semestre"].", " ;
  	$query .= " prv_qtd_questao = ".$_REQUEST["qt_quest"].", " ;
  	$query .= " prv_data = '".$data."', " ;
  	$query .= " prv_crs_id = ".$_REQUEST["curso"] ;
  	$query .= " WHERE ( prv_id = ".$_REQUEST["prvcod"]." ) " ; 
  
}

if ( mysql_query ( $query ) ) {
	
	if ($aux == 1) {
		
		$queryqst  = " INSERT INTO Questao ( qst_id, qst_ordem, qst_dtprevelab, qst_dtprevrev, qst_dtprevconc, qst_stq_id, qst_prv_id ) " ;
		$queryqst .= " VALUES ";

		for ($i = 1; $i <= $_REQUEST["qt_quest"]; $i++) {

			$qstid = contador("QST") ;
			$queryqst .= " (".$qstid.", ".$i.", '".$_REQUEST["dt_elab"]."', '".$_REQUEST["dt_rev"]."', '".$_REQUEST["dt_conc"]."', 1, ".$prvcod ;

			if ( $i == $_REQUEST["qt_quest"] ) {
				$queryqst .= " )" ;
			}else{
				$queryqst .= " )," ;
			}
		}
	   
		if ( mysql_query ( $queryqst )) {
			header ( "Location: prova.php?prvcod=".$prvcod ) ;
		}else{
			echo $queryqst ;
			echo "<br>" ; 
			echo "Erro no registro." ; 
		}
	}else{
		
		$queryqst  = " UPDATE Questao SET " ;
		$queryqst .= " qst_dtprevelab = '".$_REQUEST["dt_elab"]."', " ;
		$queryqst .= " qst_dtprevrev = '".$_REQUEST["dt_rev"]."', " ;
		$queryqst .= " qst_dtprevconc = '".$_REQUEST["dt_conc"]."' " ;
		$queryqst .= " WHERE ( qst_prv_id = ".$_REQUEST["prvcod"]." ) " ; 
		
		if ( mysql_query ( $queryqst )) {
			header ( "Location: prova.php?prvcod=".$prvcod ) ;
		}else{
			echo $queryqst ;
			echo "<br>" ; 
			echo "Erro no registro." ; 
		}
	}
	
} else {
	echo $query ;
	echo "<br>" ; 
	echo "Erro no registro." ; 
}

?>
