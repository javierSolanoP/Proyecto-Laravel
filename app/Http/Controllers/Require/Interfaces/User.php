<?php
namespace App\Http\Controllers\Require;

interface UserInterface {

    //Metodo para registrar los datos del usuario:
    public function registerData();

    //Metodo para validar los datos del usuario:
    public function validateLogin();

    //Metodo para restablecer contrasenia del usuario:
    public function recoverPassword();

    //Metodo para actualizar los datos del usuario:
    public function updateData();

}

