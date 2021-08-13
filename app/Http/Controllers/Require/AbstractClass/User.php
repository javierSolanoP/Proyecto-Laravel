<?php 
namespace App\Http\Controllers\Require\AbstractClass;

abstract class User {

    protected int $id_usuario, $rol_id;
    protected string $nombre,
                     $apellido,
                     $email,
                     $password,
                     $fechaDeRegistro;
                     

}