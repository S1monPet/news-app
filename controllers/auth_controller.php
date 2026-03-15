<?php
/*
    Controller za avtentikacijo. Vključuje naslednje standardne akcije:
        login: izpiše obrazec za prijavo
        authenticate: obdela podatke iz prijavnega obrazca in poskrbi za prijavo oz. izpis napake
        logout: poskrbi za uničenje seje in odjavo uporabnika
*/

require_once 'models/users.php'; // Vključimo model za uporabnike

class auth_controller
{
    function login(){
        $error = "";
        if(isset($_GET["error"]) && $_GET["error"]){
            $error = "Neveljavni prijavni podatki";
        }
        require_once('views/auth/login.php');
    }
    
    function authenticate(){
        //Preveri prijavne podatke
        if(($user_id = User::authenticate($_POST["username"], $_POST["password"])) >= 0 ){
            //Zapomni si prijavljenega uporabnika v seji in preusmeri na index.php
            $_SESSION["USER_ID"] = $user_id;
            header("Location: /");
            die();
        } else{
            header("Location: /auth/login?error=true");
            die();
        }
    }

    function logout(){
        session_unset();
        session_destroy();
        header("Location: /");
    }
}