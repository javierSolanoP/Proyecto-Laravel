<?php
namespace App\Http\Controllers\Admin\Class;

use App\Http\Controllers\Require\AbstractClass\User;
use App\Http\Controllers\Require\Trait\MethodsUser;
use App\Http\Controllers\Require\Trait\MethodsConnect;

class Administrador extends User{

        public function __construct(protected int $id_usuario = 0,
                                    protected string $nombres = '',
                                    protected string $apellido = '',
                                    protected string $email = '',
                                    protected string $password = '',
                                    protected string $confirmPassword = '',
                                    protected string $fechaDeRegistro = '',
                                    protected int $rol_id = 0,
                                    private string $direccion = '',
                                    private string $telefono = '',
                                    private $estado = null,
                                    protected $sesion = false){}

    public function __call($name, $arguments)
    {
        $prefix = substr($name, 0, 3);

        if($prefix == 'get'){

            $propertyName = substr(strtolower($name), 3);
            return $this->$propertyName;

        }
    }

    use MethodsUser;
    use MethodsConnect;

}