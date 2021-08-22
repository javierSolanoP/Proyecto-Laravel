<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Class\Administrador;

class AdministradorController extends Controller
{

    public function validateData()
    {
        //Recibe los datos del modulo User: 
        $connect = new Administrador;
        $data = $connect->deliverConnect();

        //Realiza la validacion: 
        $admin = new Administrador(nombres: $data['nombres']['nombres'],
                                   apellido: $data['apellido']['apellido'],
                                   email: $data['email']['email'],
                                   password: $data['password']['password'],
                                   confirmPassword: $data['confirmPassword']['confirmPassword']);

                $_SESSION['sign-in'] = $admin;

                $register = $admin->validateData();

                if($register){
                    return $register;
                }else{
                    session_destroy($_SESSION['sign-in']);
                    $register;
                }     
                
    }

    public function validateLogin(){

        //Recibe los datos del modulo User: 
        $connect = new Administrador;
        $data = $connect->deliverConnect();
 
        //Realiza la validacion: 
        $admin = new Administrador(email: $data['email'],
                                   password: $data['password'],
                                   confirmPassword: $data['confirmPassword']);

                $_SESSION['login'] = $admin;

                $login = $admin->validateLogin();

                if($login){
                    return $login;
                }else{
                    session_destroy($_SESSION['login']);
                    $login;
                }

    }
}
