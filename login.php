<?php
require "inc/cabecalho.php";
require "inc/funcoes-sessao.php";
require "inc/funcoes-usuarios.php";

/* Mensagens para os processos de erros no login */
if( isset($_GET['acesso_proibido']) ){
  $feedback = "Você deve logar primeiro!";
} elseif( isset($_GET['logout']) ) {
  $feedback = "Você saiu do sistema!";
} elseif( isset($_GET['nao_encontrado']) ) {
  $feedback = "Usuário não encontrado!";
} elseif( isset($_GET['senha_incorreta']) ) {
  $feedback = "Senha Incorreta!";          
} elseif( isset($_GET['campos_obrigatorios']) ) {
  $feedback = "Preencha todos os campos!";
} else {
  $feedback = "";
}

// 1) Verifica se o botao entrar for acionado 

if(isset($_POST['entrar'])){

  //2) [IF/ELSE]  somente se o botao for acionando começa o 2 if else verificando se os campos esntão vazios se estiver ele volta pro login php e cria uma parametro de url dizendo campos obrigatórios 

  if( empty($_POST['email']) || empty($_POST['senha']) ){
    //Redireciona para o login com o parametro indicando campos obrigatórios se for verdade

    header("location:login.php?campos_obrigatorios");
  }else{
    //Caso contrário pegue o email e senha digitadas
    $email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    // Verificar no banco se existe alguém com o email informado 
    $usuario = buscarUsuario($conexao, $email);

    //3) [ IF/ELSE ] Se for Diferente de Nulo é pq tem usuário
    
    if($usuario != null){
      //4) [IF/ELSE] Se as senhas forem iguais a do banco de dados
      if(password_verify($senha, $usuario['senha'])){
        //4) Então inicia o login para área administrativa
        login($usuario['id'], $usuario['nome'], $usuario['email'], $usuario['senha']);
        header("location:admin/index.php");
      } else {
        //4) Se a senha estiver errada redireciona para login e cria um parametro indicando  que a sneha esta incorreta
        header("location:login.php?senha_incorreta");
      }
    }else{
      //3) se o email e a senha nao exixtirem cria um parametro de url indicando que o usuario nao existe
      header("location:login.php?nao_encontrado");
    }
  }
}
?>
<div class="row">
  <article class="col-12 bg-white rounded shadow my-1 py-4">
    <h2 class="text-center">Acesso à área administrativa</h2>

    <form action="" method="post" id="form-login" name="form-login" class="mx-auto w-50">

      <p class="my-2 alert alert-warning text-center">
        <?=$feedback?>
      </p>

      <div class="form-group">
        <label for="email">E-mail:</label>
        <input class="form-control" type="email" id="email" name="email">
      </div>
      <div class="form-group">
        <label for="senha">Senha:</label>
        <input class="form-control" type="password" id="senha" name="senha">
      </div>

      <button class="btn btn-primary btn-lg" name="entrar" type="submit">Entrar</button>

    </form>
  </article>

</div>

<?php
require "inc/rodape.php";
?>