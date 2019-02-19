<?php 
error_reporting(E_ALL) ; 
ini_set('display_errors', '1') ;

require_once ( "../lib/connect.php" ) ;
require_once ( "upload.php" ) ;

session_start () ;

if ( !array_key_exists ( "s_login", $_SESSION ) ) {
        exit ; 
}

conectar () ;

mysql_select_db ("tuy09") or DIE ("Erro na seleção do BD.<br>") ;
		
if ( array_key_exists ( "qstcod", $_REQUEST ) ) {
	
	if ( ($_FILES["imagem"]["name"] != "") && ($_FILES["imagem"]["tmp_name"] != "") ) {
		if ( !anexar_imagem($_REQUEST["qstcod"], $_REQUEST["posicao"], $_FILES['imagem'] ['name'], $_FILES['imagem'] ['tmp_name']) ) {
			echo "Erro ao anexar imagem" ;
		}
	}
	
	$queryqst  = " UPDATE Questao SET " ;
	$queryqst .= " qst_enunc = '".$_REQUEST["enunciado"]."', " ;
	$queryqst .= " qst_perg = '".$_REQUEST["pergunta"]."', " ;
	$queryqst .= " qst_resp = '".$_REQUEST["resposta"]."', " ;
	$queryqst .= " qst_revisor = '".$_REQUEST["revisao"]."', " ;
	$queryqst .= " qst_fonte = '".$_REQUEST["fonte"]."'" ;
	if ( $_REQUEST["tpqcod"] != 1 ) {
		$queryqst .= ", qst_gabarito = '".$_REQUEST["gabarito"]."' " ;
	}
	$queryqst .= " WHERE ( qst_id = ".$_REQUEST["qstcod"]." ) " ; 
	
	if ( mysql_query ( $queryqst )) {
		echo ("salvou");
		if ( $_REQUEST["tpqcod"] != 1 && $_REQUEST["tpqcod"] != 0 ) {
			
			for ( $i = 1; $i <= 5; $i++ ) {
				$queryauxlt  = " UPDATE Alternativas SET " ;
				$queryauxlt .= " alt_desc = '".$_REQUEST["alt{$i}"]."' " ;
				$queryauxlt .= " WHERE ( alt_ordem = ".$i." and alt_qst_id = ".$_REQUEST["qstcod"]." ) " ;

				if ( mysql_query ( $queryauxlt )) {
					continue ;
				}else{
					echo $queryauxlt ;
					echo "Erro no registro das Alternativas." ;
				}
			}
				
		}
			
		if ( $_REQUEST["tpqcod"] == 2 ) {
			
			$queryass = " SELECT 1 FROM Assercoes WHERE ass_qst_id = ".$_REQUEST["qstcod"] ;
			$resultass = mysql_query ( $queryass ) ;
			
			if ( mysql_num_rows($resultass) > 0 ) {
				
				if ( mysql_num_rows($resultass) != $_REQUEST["propqt"] ) {
					
					$querydel = " DELETE FROM Assercoes WHERE ass_qst_id = ".$_REQUEST["qstcod"] ;
					
					if ( mysql_query ( $querydel )) {
						
						$queryasd  = " INSERT INTO Assercoes ( ass_ordem, ass_desc, ass_qst_id ) " ;
						$queryasd .= " VALUES " ;

						for ($i = 1; $i <= $_REQUEST["propqt"]; $i++) {

							$queryasd .= " (".$i.", '".$_REQUEST["prop{$i}"]."', ".$_REQUEST["qstcod"] ;

							if ( $i == $_REQUEST["propqt"] ) {
								$queryasd .= " )" ;
							}else{
								$queryasd .= " )," ;
							}
						}

						if ( mysql_query ( $queryasd )) {
							header('Location: ' . $_SERVER['HTTP_REFERER']);
						}else{
							echo $queryasd ;
							echo "<br>" ; 
							echo "Erro no registro." ; 
						}
						
					}else{
						return $querydel ;
					}
					
				}else{
			
					for ( $i = 1; $i <= mysql_num_rows($resultass); $i++ ) {
						$queryaux  = " UPDATE Assercoes SET " ;
						$queryaux .= " ass_desc = '".$_REQUEST["prop{$i}"]."' " ;
						$queryaux .= " WHERE ( ass_ordem = ".$i." and ass_qst_id = ".$_REQUEST["qstcod"]." ) " ;

						if ( mysql_query ( $queryaux )) {

							if ($i == mysql_num_rows($resultass)){
								header('Location: ' . $_SERVER['HTTP_REFERER']);
							}else{
								continue ;
							}
						}else{
							echo $queryaux ;
							echo "Erro no registro das Asserções." ;
						}
					}
					
				}
			}else{
				
				$queryauxs  = " INSERT INTO Assercoes ( ass_ordem, ass_desc, ass_qst_id ) " ;
				$queryauxs .= " VALUES " ;

				for ($i = 1; $i <= $_REQUEST["propqt"]; $i++) {

					$queryauxs .= " (".$i.", '".$_REQUEST["prop{$i}"]."', ".$_REQUEST["qstcod"] ;

					if ( $i == $_REQUEST["propqt"] ) {
						$queryauxs .= " )" ;
					}else{
						$queryauxs .= " )," ;
					}
				}

				if ( mysql_query ( $queryauxs )) {
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				}else{
					echo $queryauxs ;
					echo "<br>" ; 
					echo "Erro no registro." ; 
				}
				
			}
			
		}elseif ( $_REQUEST["tpqcod"] == 4 ) {
			
			for ( $i = 1; $i <= 2; $i++ ) {
				$queryaux4  = " UPDATE Assercoes SET " ;
				$queryaux4 .= " ass_desc = '".$_REQUEST["prop{$i}"]."' " ;
				$queryaux4 .= " WHERE ( ass_ordem = ".$i." and ass_qst_id = ".$_REQUEST["qstcod"]." ) " ;

				if ( mysql_query ( $queryaux4 )) {
					
					if ($i == 2){
						header('Location: ' . $_SERVER['HTTP_REFERER']);
					}else{
						continue ;
					}
				}else{
					echo $queryaux4 ;
					echo "Erro no registro das Asserções." ;
				}
			}
			
		}else{	
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}

	}else{
		echo $queryqst ;
		echo "<br>" ; 
		echo "Erro no registro" ; 
	}
}
?>