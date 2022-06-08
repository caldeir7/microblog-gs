<?php

require "../inc/funcoes-sessao.php";
require "../inc/funcoes-posts.php";
verificaAcesso();

$IDusuarioLogado = $_SESSION['id'];
$tipodeUsuariologado = $_SESSION['tipo'];

$idPost = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
excluirPost($conexao, $idPost, $IDusuarioLogado, $tipodeUsuariologado);
header("location:posts.php");