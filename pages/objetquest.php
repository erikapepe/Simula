<?php require ( "../lib/connect.php" ) ; ?>
<?php session_start () ?>
<?php 
	
conectar () ;

$aux = 1 ;

if ( array_key_exists ( "qstcod", $_REQUEST ) ) {
	
	$queryqst  = " SELECT qst_ordem, qst_enunc, qst_perg, qst_resp, qst_revisor, qst_fonte, qst_tpq_id, qst_gabarito, img_desc, img_pos_id " ;
  	$queryqst .= " FROM Questao LEFT JOIN Imagem ON qst_id = img_qst_id WHERE qst_id = ".$_REQUEST["qstcod"] ;

  	$result = mysql_query ( $queryqst ) ;
  	$questret = mysql_fetch_object ( $result ) ;
}
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<?php
    echo '<h4 class="modal-title">Formulário de Cadastro da Questão '.$questret->qst_ordem.'</h4>' ;
?>
</div>
<form name="questao" enctype="multipart/form-data">
	<?php
	if ( array_key_exists ( "qstcod", $_REQUEST ) ) {
	  echo '<input type=hidden name=qstcod value='.$_REQUEST["qstcod"].'> ' ;
	  echo '<input type=hidden name=tpqcod value='.$questret->qst_tpq_id.'> ' ;
	}
	?>
	<div class="modal-body">
	  <div class="row">	
		  <div class="col-lg-12">	
            <label for="message-text" class="control-label">Enunciado:</label>
            <textarea id="message-text" name="enunciado" class="form-control"><?php echo $questret->qst_enunc ?></textarea>
		  </div>
	  </div>
	  <div class="row top-buffer">
		<div class="col-lg-12">	
			<label for="message-text" class="control-label">Pergunta:</label>
			<textarea id="message-text" name="pergunta" class="form-control"><?php echo $questret->qst_perg ?></textarea>
		</div>
	  </div>
	  <div class="row top-buffer">
		<div class="col-lg-12">
			<label for="message-text" class="control-label">Alternativas:</label>
			<ol type="a">
			  <?php 
				$queryalt  = " SELECT alt_id, alt_ordem, alt_desc " ;
				$queryalt .= " FROM Alternativas WHERE alt_qst_id = ".$_REQUEST["qstcod"] ;
				$resultalt = mysql_query ( $queryalt ) ;
				
				while ( ($questalt = mysql_fetch_object ( $resultalt )) || $aux <= 5 ) {
					echo '<li style=" vertical-align: middle; width: 100%; margin-bottom:10px;">' ;
					echo '<textarea id="message-text" rows="1" name="alt'.$aux.'" class="form-control" style="vertical-align: inherit; display:initial">'.$questalt->alt_desc.'</textarea>' ;
					$aux++ ;
					echo '</li>' ;
				}
			  ?>
			</ol>
		</div>
	  </div>
	  <div class="row top-buffer">
		<div class="col-lg-12">
			<label for="message-text" class="control-label">Alternativa Correta:</label>
			<select name="gabarito" class="form-control">
				<option value=""> </option>
				<option value="a" <?php if ($questret->qst_gabarito == "a") { echo " selected "; } ?>>a)</option>
				<option value="b" <?php if ($questret->qst_gabarito == "b") { echo " selected "; } ?>>b)</option>
				<option value="c" <?php if ($questret->qst_gabarito == "c") { echo " selected "; } ?>>c)</option>
				<option value="d" <?php if ($questret->qst_gabarito == "d") { echo " selected "; } ?>>d)</option>
				<option value="e" <?php if ($questret->qst_gabarito == "e") { echo " selected "; } ?>>e)</option>
			</select>
		</div>
	  </div>
	  <div class="row top-buffer">
		<div class="col-lg-12">
			<label for="message-text" class="control-label">Justificativa:</label>
			<textarea id="message-text" name="resposta" class="form-control"><?php echo $questret->qst_resp ?></textarea>
		</div>
	  </div>
	  <div class="row top-buffer">
		<div class="col-lg-12">	
			<label for="message-text" class="control-label">Revisão:</label>
			<textarea id="message-text" name="revisao" class="form-control"><?php echo $questret->qst_revisor ?></textarea>
		</div>
	  </div>
	  <div class="row top-buffer">
		<div class="col-lg-12">	
			<label for="message-text" class="control-label">Fonte:</label>
			<textarea id="message-text" name="fonte" class="form-control"><?php echo $questret->qst_fonte ?></textarea>
		</div>
	  </div>
	  <div class="row top-buffer">
		<div class="col-lg-8">
			<label for="message-text" class="control-label">Escolher Imagem:</label>
			<input type="file" name="imagem" />
		</div>
	  	<div class="col-lg-4">
			<label for="message-text" class="control-label">Posição da Imagem:</label>
			<select name="posicao" class="form-control">
			<?php 
				echo "<OPTION VALUE=0> </OPTION> " ;
				$query  = "SELECT pos_id, pos_desc from PosicaoImg " ;
				$query .= " ORDER BY pos_desc ; " ;
				$result = mysql_query ($query) ;

				while ( $posic = mysql_fetch_object ($result) ) {
					echo "<OPTION VALUE=".$posic->pos_id ;
					if ( $questret->img_pos_id == $posic->pos_id ) {
						echo " selected " ;
					}
				echo ">".(utf8_encode($posic->pos_desc))."</OPTION> " ;
				}
			?>
			</select>
		</div>
	  </div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		<button type="button" onclick="salvar()" value=Gravar class="btn btn-primary">Salvar Alterações</button>
		<div id="msgSuccess" style="width:400px; color:green; float:left;display:none;">Dados salvos com sucesso</div>
		<div id="msgError" style="width:400px; color:red; float:left;;display:none;">Erro ao salvar a questão</div>
	</div>
</form>

<script>
	function salvar() {
		var data = new FormData($('form')[1]);
		$.ajax({
			type: "POST",
			url: "reg_questcont.php",
			data: data,
			contentType: false,
			cache: false,
			processData: false
		}).done(function(data) {
			console.log(data);
    		$('#msgError').hide();
    		$('#msgSuccess').show();
  		}).fail(function() {
    		$('#msgSuccess').hide();
    		$('#msgError').show();
  		});
	}
</script>