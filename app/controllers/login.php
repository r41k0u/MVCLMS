<?php

namespace Controller;

session_start();

class Login
{

    public function get()
    {

        echo \View\Loader::make()->render("templates/login.twig");
    }

    public function post()
    {
        if(\Controller\Utils::isSetAll($_POST["name"], $_POST["password"])){
        $Name = $_POST["name"];
        $Password = $_POST["password"];
        $Result = \Model\Auth::verifyLogin($Name, $Password);

        if ($Result['PWD'] == null) {
            echo \View\Loader::make()->render("templates/login.twig", array(
                "EmailDNE" => true,
            ));
        } else if (password_verify($Password, $Result['PWD'])) {

            $_SESSION["UserName"] = $Name;
            $_SESSION["Role"] = "User";
            $_SESSION["LoggedIn"] = 1;

            header("Location:/user");
        } else {
            echo \View\Loader::make()->render("templates/login.twig", array(
                "wrongpw" => true,
            ));
        }
    }}
}
