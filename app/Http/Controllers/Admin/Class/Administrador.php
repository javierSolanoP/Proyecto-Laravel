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

    //Metodos que realiza un usuario: 
    use MethodsUser;

    //Metodo para validar una categoria de producto: 
    public function validateCategory()
    {

        if($_SESSION['category']){

            $data = $_SESSION['category'];
            $validate = [];

            if(!empty($data->nombre) && !preg_match("/[0-9]/", $data->nombre)){

                $validate['nombre'] = true;

            }else{

                $response = ['Error' => 'Categoria vacia o con tipo de dato no permitido.'];
                die($response);

            }

        }

    }

    //Metodo para validar un producto: 
    public function validateProduct()
    {

        if($_SESSION['product']){

            $data = $_SESSION['product'];
            $validate = [];

            //Validar nombre de producto: 
            if(!empty($data->nombre) && !preg_match("/[0-9]/", $data->nombre)){

                $validate['nombre'] = true;

            }else{

                $response = ['Error' => 'Campo nombre: vacio o tipo de dato no permitido.'];
                die($response);

            }

            //Validar descripcion de producto: 
            if(!empty($data->descripcion && !preg_match("/[0-9]/", $data->descripcion))){

                $validate['descripcion'] = true;

            }else{

                $response = ['Error' => 'Campo descripcion: vacio o tipo de dato no permitido.'];
                die($response);

            }

            //Validar marca del producto: 
            if(!empty($data->marca && !preg_match("/[0-9]/", $data->marca))){

                $validate['marca'] = true;

            }else{

                $response = ['Error' => 'Campo marca: vacio o tipo de dato no permitido.'];
                die($response);

            }

            //Validar precio del producto: 
            if(!empty($data->precio) && preg_match("/[0-9]/", $data->precio)){

                if(is_string($data->precio) || is_integer($data->precio) || is_float($data->precio)){

                    $validate['precio'] = doubleval($data->precio);

                }

            }else{

                $response = ['Error' => 'Campo precio: vacio o tipo de dato no permitido.'];
                die($response);

            }

            //Validar cantidades del producto: 
            if(!empty($data->cantidad) && preg_match("/[0-9]/", $data->cantidad)){

                if(is_string($data->cantidad) || is_double($data->cantidad) || is_float($data->cantidad)){

                    $validate['cantidad'] = intval($data->cantidad);

                }

            }else{

                $response = ['Error' => 'Campo cantidad: vacio o tipo de dato no permitido.'];
                die($response);

            }

            $response = ['validate' => true, 'fields' => $validate];
            return $response;

        }else{

            $response = ['validate' => false, 'Error' => 'No existen datos.'];
            return $response;

        }

    }

    //Metodos para realizar una conexion entre modulos: 
    use MethodsConnect;  
    
}