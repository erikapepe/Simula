<?php

function anexar_imagem ($qstcod, $posicao, $imgnome, $imgtemp) {
	
	if ($imgnome != "") {
		
		$imgnome = strtoupper ( $imgnome ) ; 

		$imgnome = str_replace ( " ", "_", $imgnome ) ;
		$imgnome = str_replace ( "Ã", "A", $imgnome ) ;
		$imgnome = str_replace ( "Â", "A", $imgnome ) ;
		$imgnome = str_replace ( "Á", "A", $imgnome ) ;
		$imgnome = str_replace ( "Õ", "O", $imgnome ) ;
		$imgnome = str_replace ( "Ô", "O", $imgnome ) ;
		$imgnome = str_replace ( "Ó", "O", $imgnome ) ;
		$imgnome = str_replace ( "Ç", "C", $imgnome ) ;
		$imgnome = str_replace ( "É", "E", $imgnome ) ;
		$imgnome = str_replace ( "Ê", "E", $imgnome ) ;
		$imgnome = str_replace ( "Í", "I", $imgnome ) ;
		$imgnome = str_replace ( "Ú", "U", $imgnome ) ;

		$imgnome = urlencode( $imgnome );

		if ( move_uploaded_file ( $imgtemp, "../imagens/{$imgnome}" ) ) 
		{
			$inserir  = "INSERT INTO Imagem ( img_desc, img_qst_id, img_pos_id ) " ;
			$inserir .= "VALUES ( '".$imgnome."', ".$qstcod.", ".$posicao." ) ; " ; 

			if ( mysql_query ( $inserir ) ) { 
				return true ;
			} else {
				return false ; 
			}

		}
		else
		{
			return false ; 
		}

	} 

}
