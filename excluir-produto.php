<?php

    require_once 'src/conexao-bd.php';
    require_once 'src/Modelo/Produto.php';
    require_once 'src/Repositorio/ProdutoRepositorio.php';

    $produtoRepositorio = new ProdutoRepositorio($pdo);
    $produtoRepositorio->deletar($_POST['id']);

    header("Location: admin.php");

    
    
?>