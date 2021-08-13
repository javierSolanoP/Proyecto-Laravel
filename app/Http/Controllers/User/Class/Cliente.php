<?php
namespace App\Http\Controllers\User\Class;

use App\Http\Controllers\Require\AbstractClass\User;
use App\Http\Controllers\Require\Trait\MethodsUser;

class Cliente extends User  {
   
    private string  $direccion,
                    $telefono;
    private  $estado;


    public function __construct(
                                private string $nombres = '',
                                protected string $apellido = '',
                                protected string $email = '',
                                protected string $password = '',
                                protected string $confirmPassword = '',
                                protected string $fechaDeRegistro = '',
                                protected int $rol_id = 0){}

    public function __toString()
    {
        return 
              "Nombres: {$this->nombres}\n"
              ."Apellido: {$this->apellido}\n"
              ."Email: {$this->email}\n"
              ."password: {$this->password}\n"
              ."confirmPassword: {$this->confirmPassword}\n"
              ."rol_id: {$this->rol_id}\n";
              
    }

    use MethodsUser;

}