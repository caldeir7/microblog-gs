<?php
require "inc/cabecalho.php";
require "inc/funcoes-posts.php";
$idPost = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$postDetails = lerDetalhes($conexao, $idPost);

?>
<div class="row">
	<!-- INÍCIO ROW -->

	<article class="col-12 bg-white rounded shadow my-1 py-4">
		<h2><?=$postDetails['titulo']?></h2>
		<p class="font-weight-light">
			<time>
				<?=formataData($postDetails['data'])?>
			</time> - <span><?=$postDetails['autor']?></span>
		</p>

		<img src="imagens/<?=$postDetails['imagem']?>" alt="Imagem de destaque do post" class="float-left pr-2 img-fluid">

		<p><?=$postDetails['texto']?></p>
	</article>

</div> <!-- FIM ROW -->

<?php
require "inc/rodape.php";
?>