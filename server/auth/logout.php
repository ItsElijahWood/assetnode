<?php
namespace Server\Auth;

class Logout
{
    public function __construct()
    {
    }
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: /");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $logout = new Logout();

    $logout->logout();
}
