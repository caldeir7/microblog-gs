<?php 
require "../inc/cabecalho-admin.php";
require "../inc/funcoes-usuarios.php";
// variavel session['id'] inves da variavel que vem no parametro da url chamada QUERYSTRING 
$dados = lerUmUsuario($conexao, $_SESSION['id']);

if(isset($_POST['atualizar'])){

  $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $tipo = $_SESSION['tipo']; // recupera qual o tipo do usuário.
  

  // 1) if Verifica se o campo input ('senha') esta vazio.
  if(empty($_POST['senha'])){
    // se estiver nao faça nada
    $senha = $dados['senha'];
  }else{
    //caso contrario se o usuario digitou algo no campo senha precisamos verificar a senha digitada
    $senha = verificaSenha($_POST['senha'], $dados['senha']);
  }
  atualizarUsuario($conexao, $_SESSION['id'], $nome, $email, $tipo, $senha);
  header("location:index.php");

}

?>
  <div class="row">
    <article class="col-12 bg-white rounded shadow my-1 py-4">
      <h2 class="text-center">Atualizar meu perfil</h2>

      <form action="" method="post" id="form-atualizar" name="form-atualizar" class="mx-auto w-75">
        <p class="my-2 alert alert-warning text-center">
    
        </p>
        <div class="form-group">
          <label for="nome">Nome:</label>

          <input  class="form-control" required type="text" id="nome" name="nome" placeholder="Nome (obrigatório)" 
          value="<?=$dados['nome']?>">
          
        </div>
        <div class="form-group">
          <label for="email">E-mail:</label>

          <input class="form-control" required type="email" id="email" name="email" placeholder="E-mail(obrigatório)" value="<?=$dados['email']?>">
        </div>
        <div class="form-group">
          <label for="senha">Senha</label>

          <input class="form-control" type="password" id="senha" name="senha"  placeholder="Preencha apenas se for alterar">
        </div>

        
        <button class="btn btn-lg btn-primary" name="atualizar">Atualizar</button>
      </form>
    </article>
  </div>

<?php
require "../inc/rodape-admin.php"; 
?>