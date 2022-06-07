<?php
require "conecta.php";

/* Usada em post-insere.php */
function inserirPost(mysqli $conexao, string $titulo, string $texto, string $resumo, $imagem, int $idUsuarioLogado){
    $sql = "INSERT INTO posts(titulo,texto, resumo, imagem, usuario_id) VALUES('$titulo', '$texto', '$resumo', '$imagem', '$idUsuarioLogado')";
    
    mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
} // fim inserirPost



/* Usada em posts.php */
function lerPosts(mysqli $conexao, int $idUsuarioLogado, string $tipoUsuarioLogado ):array {
    // Se o tipo de usuario for admin
    if ($tipoUsuarioLogado == 'admin') {
        // SQL que traga todos os posts
        $sql = "SELECT posts.id, posts.titulo, posts.data, usuarios.nome AS autor from posts INNER JOIN usuarios ON posts.usuario_id = usuarios.id ORDER BY data DESC";
        
    } else {
        // Senão, SQL que traga os posts somente do editor
        $sql = "SELECT id, titulo, data FROM posts WHERE usuario_id = $idUsuarioLogado ORDER BY data";
    }
    
    $resultado = mysqli_query($conexao,$sql) or die(mysqli_error($conexao));
    $posts = [];
    while($post = mysqli_fetch_assoc($resultado)){
        array_push($posts, $post);
    }
    return $posts;
} // fim lerPosts


/* Usada em post-atualiza.php */
function lerUmPost(mysqli $conexao, int $id, ):array {    
    $sql = "SELECT titulo, texto, resumo, imagem FROM posts WHERE id = $id;";

	$resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
    return mysqli_fetch_assoc($resultado); 
} // fim lerUmPost



/* Usada em post-atualiza.php */
function atualizarPost(mysqli $conexao, int $IdusuarioLogado, string $tipodeUusuarioLog){
    // if($tipodeUusuarioLog == 'admin'){
        // $sql = ""
    }
    // $sql = "UPDATE posts SET titulo = "$titulo", texto = "$texto", resumo = "$resumo" WHERE id =$IdusuarioLogado;";

    // mysqli_query($conexao, $sql) or die(mysqli_error($conexao));       
// } // fim atualizarPost



/* Usada em post-exclui.php */
function excluirPost(mysqli $conexao){    
    $sql = "";

	mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
} // fim excluirPost



/* Funções utilitárias */

/* Usada em post-insere.php e post-atualiza.php */
function upload($arquivo){
    // Definindo os tipos de imagem aceitos
    $tiposValidos = ["image/png","image/jpg","image/jpeg","image/gif","image/svg+xml"];
    //Verificar se o arquivo enviado nao [e um dos aceitos]
    if ( !in_array($arquivo['type'], $tiposValidos) ) {
        die( " <script> alert('Formato invalido.'); history.back(); </script> " );
    }

    //Acessando o nome do arquivo
    $nome = $arquivo['name']; // $__FILES['arquivo']['name'];

    //Acessando ddos de acesso temporário ao arquivo
    $temporario = $arquivo['tmp_name'];
    //Pasta de destino do arquivo que está sendo enviado
    $destino = "../imagens/$nome";
    //Se o processo de envio temporario para destino for feito com sucesso, então a funçãp retorna verdadeira(indicando o sucesso do processo)
    if( move_uploaded_file($temporario, $destino) ){
        return true;
    }
} // fim upload



/* Usada em posts.php e páginas da área pública */
function formataData(){ 
    
} // fim formataData



/*** Funções para a área PÚBLICA do site ***/

/* Usada em index.php */
function lerTodosOsPosts(mysqli $conexao):array {
    $sql = "";
    
    $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
    $posts = [];
    while( $post = mysqli_fetch_assoc($resultado) ){
        array_push($posts, $post);
    }
    return $posts; 
} // fim lerTodosOsPosts



/* Usada em post-detalhe.php */
function lerDetalhes(mysqli $conexao):array {    
    $sql = "";

    $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
    return mysqli_fetch_assoc($resultado); 
} // fim lerDetalhes



/* Usada em search.php */
function busca($conexao):array {
    $sql = "";
        
    $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
    $posts = [];
    while( $post = mysqli_fetch_assoc($resultado) ){
        array_push($posts, $post);
    }
    return $posts; 
} // fim busca