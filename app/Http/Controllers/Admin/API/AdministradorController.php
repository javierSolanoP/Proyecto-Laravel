<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Class\Administrador;

class AdministradorController extends Controller
{

    //Recibe los datos del modulo User: 
    public function validateData()
    {
        $connect = new Administrador;
        $data = $connect->deliverConnect();

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
}
