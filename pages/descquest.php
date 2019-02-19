<?php require ( "../lib/connect.php" ) ; ?>
<?php session_start () ?>
<?php 
	
conectar () ; 

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
			<label for="message-text" class="control-label">Resposta:</label>
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
		<div id="msgSuccess" class="text-center" style="width:100%; color:green; float:left;display:none; "><span style="background-color:#DDDDDD; border-radius:10px; padding:7px;">Dados salvos com sucesso!</span></div>
		<div id="msgError" class="text-center" style="width:100%; color:red; float:left;display:none; background-color:#FAFAFA; border-radius:10px;">Erro ao salvar a questão!</div>
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