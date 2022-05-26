<?php
require "conecta.php";

// Função inserirUsuario: usada em usuario-insere.php
function inserirUsuario(mysqli $conexao, string $nome,  string $email, string $senha, string $tipo){
    $sql = "INSERT INTO usuarios(nome,email,senha,tipo) 
        VALUES('$nome', '$email','$senha','$tipo')";
    
    mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
}


// fim inserirUsuario



// Função codificaSenha: usada em usuario-insere.php e usuario-atualiza.php :string ira devolver uma string CRIPTROGAFADA
function codificaSenha(string $senha):string{
    return password_hash($senha, PASSWORD_DEFAULT);
}

// fim codificaSenha



// Função lerUsuarios: usada em usuarios.php
function lerUsuarios(mysqli $conexao):array{
        $sql = "SELECT id, nome, email, tipo FROM usuarios ORDER BY nome";

        $query = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

        $usuarios = [];

        while($usuario = mysqli_fetch_assoc($query)){
            array_push($usuarios, $usuario);

        }

        return $usuarios;
    }
// fim lerUsuarios



// Função excluirUsuario: usada em usuario-exclui.php
function excluirUsuario(mysqli $conexao, int $id){
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        //Chamando a função que ira retorna os dados de um fabricante
        excluirUsuario($conexao, $id);
        header("location:listar.php");
}

    // mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
// fim excluirUsuario



// Função lerUmUsuario: usada em usuario-atualiza.php
function lerUmUsuario(mysqli $conexao, int $id):array{
    $sql = "SELECT id, nome, email, tipo, senha FROM usuarios WHERE id = $id";
    
    $query = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    //Retornando para fora da função o resultado como array assoc.
    return mysqli_fetch_assoc($query);
}

    // mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
// fim lerUmUsuario



// Função verificaSenha: usada em usuario-atualiza.php
// function verificaSenha(string $senha):string{
//     if(){
//         echo "";
//     }else(){
//         echo "<";
//     }
// }

    // mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
// fim verificaSenha



// Função atualizarUsuario: usada em usuario-atualiza.php
function atualizarUsuario(mysqli $conexao, int $id, string $nome, string $email, string $senha, string $tipo){
    $sql= "UPDATE usuario SET nome='$nome', email ='$email', senha = '$senha', tipo = '$tipo' ";

   mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
}


// fim atualizarUsuario



// Função buscarUsuario: usada em login.php

// fim buscarUsuario



