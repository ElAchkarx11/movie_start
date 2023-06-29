<?php

require_once "models/User.php";
require_once "dao/UserDao.php";
require_once "config/db.php";
require_once "models/Message.php";
require_once "config/globals.php";

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

//Verifica o tipo do formulario

$type = filter_input(INPUT_POST, "type");

//Verificação do tipo de formulário
if ($type === "register") {

    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");


    //Verificação de dados mínimos
    if ($name && $lastname && $email && $password) {
        //verificar se as senhas batem
        if ($password === $confirmpassword) {
            //Verificar se o e-mail já está cadastrado no sistema
            if($userDao->findByEmail($email) === false){
                echo "nenhum usuário encontrado";
            }else{
                $message->setMessage("Usuário já cadastrado, tente outro", "error");
            }
        } else {
            $message->setMessage("As senhas não são iguais.", "error", "back");
        }

    } else {
        //Enviar mensagem de erro caso faltem dados
        $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
    }

} else if ($type === "login") {

}