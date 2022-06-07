<?php
require "../inc/cabecalho-admin.php"; 
require "../inc/funcoes-posts.php";
$posts = lerPosts($conexao, $_SESSION['id'], $_SESSION['tipo']);

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$dados = lerUmPost($conexao, $id);

if(isset($_POST['atualizar'])){
  $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
	$texto = filter_input(INPUT_POST, 'texto', FILTER_SANITIZE_EMAIL);
	$resumo = filter_input(INPUT_POST, 'resumo', FILTER_SANITIZE_SPECIAL_CHARS);
	
  //Lógica para a imagem Se o campo da imagem do formulario estiver vazio, então significa que o usuário não mudou a imagem.
  if(empty($_POST['imagem'])){
    $imagem = $dados['imagem']; //Manter a imagem Já Existente no banco
  } else {

  /* Caso Contrario, se o usuário alterou a imagem no campo imagem, precisaremos verificar se a imagem existe no banco de dados. */

  $imagem = verificaSenha($_POST['imagem'], $dados['imagem']);
  }
   
  
  atualizarUsuario($conexao, $id, $nome, $email, $senha, $tipo);

	header("location:usuarios.php");
  // echo "banco ".$dados['senha'];
  // echo "<br>";
  // echo "formulario ".$senha;
}

?>
       
<div class="row">
  <article class="col-12 bg-white rounded shadow my-1 py-4">
    <h2 class="text-center">Atualizar Post</h2>

    <form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar"> 
        
      <div class="form-group">
        <label for="titulo">Título:</label>
        <input value="<?=$dados['titulo']?>" class="form-control" type="text" id="titulo" name="titulo" required>
      </div>
      
      <div class="form-group">
        <label for="texto">Texto:</label>
        <textarea class="form-control" name="texto" id="texto" cols="50" rows="10" required><?=$dados['texto']?></textarea>
      </div>
      
      <div class="form-group">
        <label for="resumo">Resumo (máximo de 300 caracteres):</label>
        <span id="maximo" class="badge badge-success">0</span>
        <textarea  class="form-control" name="resumo" id="resumo" cols="50" rows="3" required maxlength="300"><?=$dados['resumo']?></textarea>
      </div>
      
      <div class="form-group">
        <label for="imagem-existente">Imagem do post:</label>
        <!-- campo somente leitura, meramente informativo -->
        <input value="<?=$dados['imagem']?>" class="form-control" type="text" id="imagem-existente" name="imagem-existente" readonly>
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