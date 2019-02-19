<?php require ( "../lib/connect.php" ) ;

session_start () ;

if ( !array_key_exists ( "s_login", $_SESSION ) ) {
        exit ; 
}

conectar () ;

mysql_select_db ("tuy09") or DIE ("Erro na seleção do BD.<br>");

if ( array_key_exists ( "qstcod", $_REQUEST ) ) {
	
	$queryqst  = " UPDATE Questao SET " ;
	$queryqst .= " qst_dtprevelab = '".$_REQUEST["dt_elab"]."', " ;
	$queryqst .= " qst_dtprevrev = '".$_REQUEST["dt_rev"]."', " ;
	$queryqst .= " qst_dtprevconc = '".$_REQUEST["dt_conc"]."', " ;
	$queryqst .= " qst_dsc_id = ".$_REQUEST["disc"].", " ;
	$queryqst .= " qst_ctd_id = ".$_REQUEST["cont"].", " ;
	$queryqst .= " qst_pro_clb_id = ".$_REQUEST["resp"].", " ;
	$queryqst .= " qst_rev_clb_id = ".$_REQUEST["rev"].", " ;
	$queryqst .= " qst_grq_id = ".$_REQUEST["grau"].", " ;
	$queryqst .= " qst_tpq_id = ".$_REQUEST["tipo"] ;
	$queryqst .= " WHERE ( qst_id = ".$_REQUEST["qstcod"]." ) " ; 
	
	if ( mysql_query ( $queryqst )) {
		
		if ($_REQUEST["tipo"] != 1 && $_REQUEST["tipo"] != 0) {
			
			$queryalt = " SELECT 1 FROM Alternativas WHERE alt_qst_id = ".$_REQUEST["qstcod"] ;
			$result = mysql_query ( $queryalt ) ;
			
			if ( mysql_num_rows($result) > 0 ) {
				header ( "Location: prova.php?prvcod=".$_REQUEST["prvcod"] ) ;
			}else{
				
				$queryaux  = " INSERT INTO Alternativas ( alt_ordem , alt_qst_id ) " ;
				$queryaux .= " VALUES " ;

				for ($i = 1; $i <= 5; $i++) {

					$queryaux .= " (".$i.", ".$_REQUEST["qstcod"] ;

					if ( $i == 5 ) {
						$queryaux .= " )" ;
					}else{
						$queryaux .= " )," ;
					}
				}

				if ( mysql_query ( $queryaux )) {
					header ( "Location: prova.php?prvcod=".$_REQUEST["prvcod"] ) ;
				}else{
					echo $queryaux ;
					echo "<br>" ; 
					echo "Erro no registro." ; 
				}
				
			}
		
		}else{
			header ( "Location: prova.php?prvcod=".$_REQUEST["prvcod"] ) ;
		}
		
		if ( $_REQUEST["tipo"] == 4 ) {
			
			$queryass = " SELECT 1 FROM Assercoes WHERE ass_qst_id = ".$_REQUEST["qstcod"] ;
			$resultass = mysql_query ( $queryass ) ;
			
			if ( mysql_num_rows($resultass) > 0 ) {
				header ( "Location: prova.php?prvcod=".$_REQUEST["prvcod"] ) ;
			}else{
				
				$queryauxs  = " INSERT INTO Assercoes ( ass_ordem , ass_qst_id ) " ;
				$queryauxs .= " VALUES " ;

				for ($i = 1; $i <= 2; $i++) {

					$queryauxs .= " (".$i.", ".$_REQUEST["qstcod"] ;

					if ( $i == 2 ) {
						$queryauxs .= " )" ;
					}else{
						$queryauxs .= " )," ;
					}
				}

				if ( mysql_query ( $queryauxs )) {
					header ( "Location: prova.php?prvcod=".$_REQUEST["prvcod"] ) ;
				}else{
					echo $queryaux ;
					echo "<br>" ; 
					echo "Erro no registro." ; 
				}
				
			}
			
		}else{
			header ( "Location: prova.php?prvcod=".$_REQUEST["prvcod"] ) ;
		}
		
	}else{
		echo $queryqst ;
		echo "<br>" ; 
		echo "Erro no registro." ; 
	}
}else{
	
	echo "<br>" ; 
	echo "Erro no registro2." ;
}
?>