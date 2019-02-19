<?php require ( "../lib/connect.php" ) ; ?>
<?php session_start () ?>
<?php 
	
conectar () ; 

if ( array_key_exists ( "qstcod", $_REQUEST ) ) {
	
	$queryqst  = " SELECT qst_ordem, qst_dtprevelab, qst_dtprevrev, " ; 
	$queryqst .= " qst_dtprevconc, qst_dsc_id, qst_ctd_id, qst_pro_clb_id, qst_rev_clb_id, " ; 
	$queryqst .= " qst_grq_id, qst_stq_id, qst_tpq_id, prv_crs_id, qst_prv_id" ;
  	$queryqst .= " FROM Questao, Prova WHERE prv_id = qst_prv_id and qst_id = ".$_REQUEST["qstcod"] ;

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
<form name="questao" method="POST" action="reg_quest.php">
	<?php
	if ( array_key_exists ( "qstcod", $_REQUEST ) ) {
	  echo '<input type=hidden name=qstcod value='.$_REQUEST["qstcod"].'> ' ;
	  echo '<input type=hidden name=prvcod value='.$questret->qst_prv_id.'> ' ;
	}
	?>
	<div class="modal-body">
	  <div class="row">
		  <div class="col-lg-4">
			<label for="recipient-name" class="control-label">Prev. Elaboração:</label>
			<input type="date" name="dt_elab" value="<?php echo $questret->qst_dtprevelab ?>" class="form-control">
		  </div>
		  <div class="col-lg-4">
			<label for="recipient-name" class="control-label">Prev. Revisão:</label>
			<input type="date" name="dt_rev" value="<?php echo $questret->qst_dtprevrev ?>" class="form-control">
		  </div>
		  <div class="col-lg-4">
			<label for="recipient-name" class="control-label">Prev. Conclusão:</label>
			<input type="date" name="dt_conc" value="<?php echo $questret->qst_dtprevconc ?>" class="form-control">
		  </div>
	  </div>
	  <div class="row top-buffer">
		  <div class="col-lg-6">
			<label>Disciplina:</label>
			<select name="disc" class="form-control">
			<?php 
				echo "<OPTION VALUE=0> </OPTION> " ;
				$query  = "SELECT dsc_id, dsc_desc from Disciplina, CursoDisc " ;
				$query .= " WHERE dsc_id = cds_dsc_id and cds_crs_id = ".$questret->prv_crs_id ;
				$query .= " ORDER BY dsc_desc ; " ;
				$result = mysql_query ($query) ;

				while ( $disc = mysql_fetch_object ($result) ) {
					echo "<OPTION VALUE=".$disc->dsc_id ;
					if ( $questret->qst_dsc_id == $disc->dsc_id ) {
						echo " selected " ;
					}
				echo ">".(utf8_encode($disc->dsc_desc))."</OPTION> " ;
				}
			?>
			</select>
		  </div>
		  <div class="col-lg-6">
			<label>Conteúdo:</label>
			<select name="cont" class="form-control">
			<?php 
				echo "<OPTION VALUE=0> </OPTION> " ;
				$query  = "SELECT ctd_id, ctd_desc from Conteudo " ; 
				$query .= " ORDER BY ctd_desc ; " ;
				$result = mysql_query ($query) ;

				while ( $resp = mysql_fetch_object ($result) ) {
					echo "<OPTION VALUE=".$resp->ctd_id ;
					if ( $questret->qst_ctd_id == $resp->ctd_id ) {
						echo " selected " ;
					}
				echo ">".(utf8_encode($resp->ctd_desc))."</OPTION> " ;
				}
			?>
			</select>
		  </div>
	  </div>
	  <div class="row top-buffer">
		  <div class="col-lg-6">
			<label>Professor Responsável:</label>
			<select name="resp" class="form-control">
			<?php 
				echo "<OPTION VALUE=0> </OPTION> " ;
				$query  = "SELECT clb_id, clb_nome from Colaborador " ; 
				$query .= " ORDER BY clb_nome ; " ;
				$result = mysql_query ($query) ;

				while ( $resp = mysql_fetch_object ($result) ) {
					echo "<OPTION VALUE=".$resp->clb_id ;
					if ( $questret->qst_pro_clb_id == $resp->clb_id ) {
						echo " selected " ;
					}
				echo ">".(utf8_encode($resp->clb_nome))."</OPTION> " ;
				}
			?>
			</select>
		  </div>
		  <div class="col-lg-6">
			<label>Professor Revisor:</label>
			<select name="rev" class="form-control">
			<?php 
				echo "<OPTION VALUE=0> </OPTION> " ;
				$query  = "SELECT clb_id, clb_nome from Colaborador " ; 
				$query .= " ORDER BY clb_nome ; " ;
				$result = mysql_query ($query) ;

				while ( $rev = mysql_fetch_object ($result) ) {
					echo "<OPTION VALUE=".$rev->clb_id ;
					if ( $questret->qst_rev_clb_id == $rev->clb_id ) {
						echo " selected " ;
					}
				echo ">".(utf8_encode($rev->clb_nome))."</OPTION> " ;
				}
			?>
			</select>
		  </div>
	  </div>
	  <div class="row top-buffer">
		  <div class="col-lg-6">
			<label>Grau:</label>
			<select name="grau" class="form-control">
			<?php 
				echo "<OPTION VALUE=0> </OPTION> " ;
				$query  = "SELECT grq_id, grq_desc from GrauQuestao " ; 
				$query .= " ORDER BY grq_desc ; " ;
				$result = mysql_query ($query) ;

				while ( $grau = mysql_fetch_object ($result) ) {
					echo "<OPTION VALUE=".$grau->grq_id ;
					if ( $questret->qst_grq_id == $grau->grq_id ) {
						echo " selected " ;
					}
				echo ">".(utf8_encode($grau->grq_desc))."</OPTION> " ;
				}
			?>
			</select>
		  </div>
		  <div class="col-lg-6">
			<label>Tipo:</label>
			<select name="tipo" class="form-control">
			<?php 
				echo "<OPTION VALUE=0> </OPTION> " ;
				$query  = "SELECT tpq_id, tpq_desc from TipoQuestao " ; 
				$query .= " ORDER BY tpq_desc ; " ;
				$result = mysql_query ($query) ;

				while ( $tipo = mysql_fetch_object ($result) ) {
					echo "<OPTION VALUE=".$tipo->tpq_id ;
					if ( $questret->qst_tpq_id == $tipo->tpq_id ) {
						echo " selected " ;
					}
				echo ">".(utf8_encode($tipo->tpq_desc))."</OPTION> " ;
				}
			?>
			</select>
		  </div>
	  </div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		<button type="submit" value=Gravar class="btn btn-primary">Salvar Alterações</button>
	</div>
</form>