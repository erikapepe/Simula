<?php

function imprimirImagem($posicao, $img) {
    if (!$img) {
        return false;
    }
    $pastaImgServidor = "../imagens";
    if ($img->img_pos_id == $posicao) {
        ?>
        <img style="margin: 0px auto;" src="<?= $pastaImgServidor ?>/<?= $img->img_desc ?>" />
        <?php
    }
}
?>

<ol>
    <!-- Imprime as questoes -->
    <?php $aux = 1; ?>
    <?php while ($result_qst = mysql_fetch_object($resource_qst)) { ?>
        <li class="qst">

            <?php
            $query_img = "SELECT img_desc, img_arq, img_pos_id "
                    . "FROM Imagem "
                    . "WHERE img_qst_id = {$result_qst->qst_id}";

            $resource_img = mysql_query($query_img);
            $img = mysql_fetch_object($resource_img);
            ?>
            <!--A QUESTAO--> 
            <p class="qst-enunciado">
                Questão <?= $aux ?>
            </p>

            <?php imprimirImagem(2, $img); ?>
            <!--O ENUNCIADO-->
            <p class="qst-enunciado-txt">
                <?= $result_qst->qst_enunc ?>
            </p>

            <?php imprimirImagem(1, $img); ?>
            <?php if ($result_qst->qst_tpq_id != 2) { ?>
                <!--A PERGUNTA-->
                <p class="qst-pergunta">
                    <?= $result_qst->qst_perg ?>
                </p>
            <?php } ?>

            <!--Para cada questão testa o tipo para determinar o que imprimir-->
            <?php if ($result_qst->qst_tpq_id == 2) { ?>
                <!--QUESTAO COM ASSERCOES-->
                <?php
                $query = "SELECT * "
                        . "FROM Assercoes "
                        . "WHERE ass_qst_id = " . $result_qst->qst_id . " "
                        . "ORDER BY ass_ordem";
                $resource_ass = mysql_query($query);
                ?>
                <?php imprimirImagem(3, $img); ?>
                <!--AS ASSERCOES-->
                <ol type="I" class="qst-tpq-ass">
                    <?php while ($result_ass = mysql_fetch_object($resource_ass)) { ?>
                        <li>
                            <?= $result_ass->ass_desc ?>
                        </li>
                    <?php } ?>
                </ol>


                <?php imprimirImagem(1, $img); ?>
                <!--A PERGUNTA PARA AS ASSERCOES-->
                <p class="qst-pergunta">
                    <?= $result_qst->qst_perg ?>
                </p>

                <?php
                $query = "SELECT alt_desc, alt_ordem "
                        . "FROM Alternativas "
                        . "WHERE alt_qst_id = " . $result_qst->qst_id . " "
                        . "ORDER BY alt_ordem";
                $resource_alt = mysql_query($query);
                ?>

                <?php imprimirImagem(4, $img); ?>
                <!--AS ALTERNATIVAS DAS ASSERCOES-->
                <ol type="a" class="qst-tpq-ass-alt">
                    <?php while ($result_alt = mysql_fetch_object($resource_alt)) { ?>
                        <li>
                            <?= $result_alt->alt_desc ?>
                        </li>
                    <?php } ?>
                </ol>

            <?php } elseif ($result_qst->qst_tpq_id == 3) { ?>

                <?php imprimirImagem(4, $img); ?>
                <!--Se do tipo 3 imprima as alternativas-->
                <?php
                $query = "SELECT alt_desc, alt_ordem "
                        . "FROM Alternativas "
                        . "WHERE alt_qst_id = " . $result_qst->qst_id . " "
                        . "ORDER BY alt_ordem";
                $resource_alt = mysql_query($query);
                ?>
                <ol type="a" class="qst-tpq-alt">
                    <?php while ($result_alt = mysql_fetch_object($resource_alt)) { ?>
                        <li>
                            <?= $result_alt->alt_desc ?>
                        </li>
                    <?php } ?>
                </ol>
            <?php } elseif ($result_qst->qst_tpq_id == 1) { ?>
                <?php imprimirImagem(5, $img); ?>
                <!--Tipo 1 deve imprimir as linhas para escrita livre da resposta-->
                <div class="qst-tpq-dsc">
                    <hr />
                    <hr />
                    <hr />
                    <hr />
                </div>
			<?php } elseif ($result_qst->qst_tpq_id == 4) { ?>
                <!--QUESTAO COM ASSERCOES-->
                <?php
                $query = "SELECT * "
                        . "FROM Assercoes "
                        . "WHERE ass_qst_id = " . $result_qst->qst_id . " "
                        . "ORDER BY ass_ordem";
                $resource_ass = mysql_query($query);
                ?>
                <?php imprimirImagem(3, $img); ?>
                <!--AS ASSERCOES-->
                <ol type="I" class="qst-tpq-ass">
                    <?php $result_ass = mysql_fetch_object($resource_ass) ?>
					<li>
						<?= $result_ass->ass_desc ?>
					</li>
					<span style="text-align: center; font-weight: bold;"> PORQUE</span>
                    <?php $result_ass = mysql_fetch_object($resource_ass) ?>
					<li>
						<?= $result_ass->ass_desc ?>
					</li>
                </ol>


                <?php imprimirImagem(1, $img); ?>
                <!--A PERGUNTA PARA AS ASSERCOES-->
                <p class="qst-pergunta">
                    <?= $result_qst->qst_perg ?>
                </p>

                <?php
                $query = "SELECT alt_desc, alt_ordem "
                        . "FROM Alternativas "
                        . "WHERE alt_qst_id = " . $result_qst->qst_id . " "
                        . "ORDER BY alt_ordem";
                $resource_alt = mysql_query($query);
                ?>

                <?php imprimirImagem(4, $img); ?>
                <!--AS ALTERNATIVAS DAS ASSERCOES-->
                <ol type="a" class="qst-tpq-ass-alt">
                    <?php while ($result_alt = mysql_fetch_object($resource_alt)) { ?>
                        <li>
                            <?= $result_alt->alt_desc ?>
                        </li>
                    <?php } ?>
                </ol>

            <?php } ?>
        </li>
        <?php $aux++; ?>
    <?php } ?>
</ol>