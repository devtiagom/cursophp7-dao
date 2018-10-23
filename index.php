<?php

    require_once('config.php');

    // Carrega um usuário
    //$root = new Usuario();
    //$root->loadById(3);
    //echo $root;

    // Carrega uma lista de usuários
    //$lista = Usuario::getList();
    //echo json_encode($lista);

    // Carrega uma lista de usuários buscando pelo login
    //$search = Usuario::searchByLogin('jo');
    //echo json_encode($search);

    // Carrega um usuário usando o login e a senha
    //$usuario = new Usuario();
    //$usuario->login('root', '!@#$');
    //echo $usuario;

    // Inserindo novo usuário
    //$aluno = new Usuario('aluna', '@lun@');
    //$aluno->insert();
    //echo $aluno;

    // Atualizando usuáro
    $usuario = new Usuario();
    $usuario->loadById(7);
    $usuario->update('professor', '!@#$%¨&*');
    echo $usuario;