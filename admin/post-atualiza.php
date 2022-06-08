<?php
require "../inc/cabecalho-admin.php"; 
require "../inc/funcoes-posts.php";
// $posts = lerPosts($conexao, $_SESSION['id'], $_SESSION['tipo']);

$idPost = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$idUsuarioLogado = $_SESSION['id'];
$tipodeUsuariologado = $_SESSION['tipo'];
$posts = lerUmPost($conexao, $idPost, $idUsuarioLogado, $tipodeUsuariologado);

// echo "<pre>";
//   var_dump($posts);
// echo "</pre>";

if(isset($_POST['atualizar'])){
  $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
	$texto = filter_input(INPUT_POST, 'texto', FILTER_SANITIZE_EMAIL);
	$resumo = filter_input(INPUT_POST, 'resumo', FILTER_SANITIZE_SPECIAL_CHARS);
  // $imagemExistente = filter_input(INPUT_POST, 'imagem-existente' FILTER_SANITIZE_SPECIAL_CHARS);

  // Se o campo imagem estiver vazio, significa que o usuário nao quer trocar de imagem
  if(empty($_FILES['imagem']['name'])){
    $imagem = $_POST['imagem-existente']; //Manter a imagem Já Existente no banco
  } else {
  /* Caso Contrario, pegue a referência(nome e extensão) e faça o processo de upload para o servidor. */
    $imagem = $_FILES['imagem']['name'];
    upload($_FILES['imagem']);
  }
  // Somente depois do processo de upload(se necessário), chamaremos a função de atualizarPost


  atualizarPost($conexao, $idPost, $idUsuarioLogado, $tipodeUsuariologado, $titulo, $texto, $resumo, $imagem );
  
  
  header("location:posts.php");
}

?>
       
<div class="row">
  <article class="col-12 bg-white rounded shadow my-1 py-4">
    <h2 class="text-center">Atualizar Post</h2>

    <form enctype="multipart/form-data" class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar"> 
        
      <div class="form-group">
        <label for="titulo">Título:</label>
        <input value="<?=$posts['titulo']?>" class="form-control" type="text" id="titulo" name="titulo" required>
      </div>
      
      <div class="form-group">
        <label for="texto">Texto:</label>
        <textarea class="form-control" name="texto" id="texto" cols="50" rows="10" required><?=$posts['texto']?></textarea>
      </div>
      
      <div class="form-group">
        <label for="resumo">Resumo (máximo de 300 caracteres):</label>
        <span id="maximo" class="badge badge-success">0</span>
        <textarea  class="form-control" name="resumo" id="resumo" cols="50" rows="3" required maxlength="300"><?=$posts['resumo']?></textarea>
      </div>
      
      <div class="form-group">
        <label for="imagem-existente">Imagem do post:</label>
        <!-- campo somente leitura, meramente informativo -->
        <input value="<?=$posts['imagem']?>" class="form-control" type="text" id="imagem-existente" name="imagem-existente" readonly>
      </div>            
          
      <div class="form-group">
        <label for="imagem" class="form-label">Caso queira mudar, selecione outra imagem:</label>
        <input class="form-control" type="file" id="imagem" name="imagem"
        accept="image/png, image/jpeg, image/gif, image/svg+xml">
      </div>
        
        <button class="btn btn-primary" name="atualizar">Atualizar post</button>
    </form>
      
  </article>
</div>

<?php
require "../inc/rodape-admin.php"; 
?>