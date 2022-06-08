<?php
require "inc/cabecalho.php";
require "inc/funcoes-posts.php";
$posts = lerTodosOsPosts($conexao);
// echo "<pre>";
// var_dump($allPosts);
// echo "</pre>";
?>



<div class="row my-1 mx-md-n1">
  <!-- INÍCIO ROW -->

  <!-- INÍCIO Card -->
  <?php foreach($posts as $allPost) { ?>
  <div class="col-md-6 my-1 px-md-1">
    <article class="card shadow-sm h-100">

      <a href="post-detalhe.php?id=<?=$allPost['id']?>" class="card-link">
        <img class="card-img-top" src="imagens/<?=$allPost['imagem']?>" alt="Imagem de destaque do post">
        <div class="card-body">
          <h5 class="card-title"><?=$allPost['titulo']?>Título do post...</h5>
          <p class="card-text"><?=$allPost['resumo']?>Resumo do post...</p>
        </div>
      </a>
    
     
    </article>
  </div> 
<?php } ?>
  <!-- FIM Card -->


</div> <!-- FIM ROW -->

<?php require "inc/rodape.php"; ?>