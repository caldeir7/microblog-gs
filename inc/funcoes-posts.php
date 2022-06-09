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
function lerUmPost(mysqli $conexao,int $idPost, int $idUsuarioLogado, string $tipodeUsuariologado ):array {    
    /* Se o usuario logado for admin então pode carregar os dados de qualquer post de qualquer usuario */
    if($tipodeUsuariologado == 'admin'){
        $sql = "SELECT id, titulo, texto, resumo, imagem, usuario_id FROM posts WHERE id = $idPost";
    }else{
    //Caso ontrario significa que é um usuário editor portanto só poderar carregar somento os dados dos seus posts
        $sql = "SELECT titulo, texto, resumo, imagem, usuario_id FROM posts WHERE id = $idPost AND usuario_id = $idUsuarioLogado";
    }

	$resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    return mysqli_fetch_assoc($resultado); 
} // fim lerUmPost



/* Usada em post-atualiza.php */
function atualizarPost(mysqli $conexao, int $idPost, int $idUsuarioLogado, string $tipodeUsuariologado, string $titulo, string $texto, string $resumo, string $imagem){
    if($tipodeUsuariologado == 'admin'){
        $sql = "UPDATE posts SET titulo = '$titulo', texto = '$texto', resumo = '$resumo', imagem = '$imagem' WHERE id = $idPost ";
    } else{
        $sql = "UPDATE posts SET titulo = '$titulo', texto = '$texto', resumo = '$resumo', imagem = '$imagem' WHERE id = $idPost AND usuario_id = $idUsuarioLogado";
    }
    mysqli_query($conexao, $sql) or die(mysqli_error($conexao));       
} // fim atualizarPost



/* Usada em post-exclui.php */
function excluirPost(mysqli $conexao, $idPost, $IDusuarioLogado, $tipodeUsuariologado){    
    if($tipodeUsuariologado == 'admin'){
        $sql = "DELETE FROM posts WHERE id = $idPost";
    }else{
        $sql = "DELETE FROM POSTS WHERE id = $idPost AND usuario_id = $IDusuarioLogado";
    }

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
function formataData(string $data):string{ 
    //Pegamos a data informada, transformamos em texto(strtotime) e depois aplicamos o formato brasileiro (dia/mês/ANO)
    return date("d/m/y H:1", strtotime($data));
} // fim formataData



/*** Funções para a área PÚBLICA do site ***/

/* Usada em index.php */
function lerTodosOsPosts(mysqli $conexao):array {
    $sql = "SELECT id, data, titulo, texto, resumo, imagem FROM posts ORDER BY data DESC";
    
    $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
    $posts = [];
    while( $post = mysqli_fetch_assoc($resultado) ){
        array_push($posts, $post);
    }
    return $posts; 
} // fim lerTodosOsPosts



/* Usada em post-detalhe.php */
function lerDetalhes(mysqli $conexao, $idPost):array {    
    $sql = "SELECT  posts.data, posts.titulo,posts.texto, posts.resumo, posts.imagem, usuarios.nome AS autor from posts INNER JOIN usuarios ON posts.usuario_id = usuarios.id WHERE posts.id = $idPost ";

    $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    return mysqli_fetch_assoc($resultado); 
} // fim lerDetalhes



/* Usada em search.php */
function busca(mysqli $conexao, string $termo):array {
    $sql = "SELECT  id, data, titulo, resumo FROM posts WHERE titulo LIKE '%$termo%' OR resumo LIKE '%$termo%'  OR texto LIKE  '%$termo%' ORDER BY data DESC";
        
    $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
    $posts = [];
    while( $post = mysqli_fetch_assoc($resultado) ){
        array_push($posts, $post);
    }
    return $posts; 
} // fim busca