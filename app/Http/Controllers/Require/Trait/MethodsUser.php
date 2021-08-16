<?php
namespace App\Http\Controllers\Require\Trait;

session_start();
trait MethodsUser{

    public function validateData(){
        
        if(isset($_SESSION['sign-in'])){

            $data = $_SESSION['sign-in'];
            $validate = array();

            //Validacion del campo nombre:
            if(!empty($data->nombres) && !preg_match("/[0-9]/", $data->nombres)){
                
                $validate['nombre'] = true;

            }else{

                $response = ['Register' => false, 'Error' => "Campo nombre: Tipo de dato no permitido o vacio."];
                die(json_encode($response));

            }

            //Validacion del campo apellido:
            if(!empty($data->apellido) && !preg_match("/[0-9]/", $data->apellido)){

                $validate['apellido'] = true;
                
            }else{

                $response = ['Register' => false, 'Error' => "Campo apellido: Tipo de dato no permitido o vacio."];
                die(json_encode($response));

            }

            //Validacion del campo email:
            if(!empty($data->email)){

                $validate['email'] = true;

            }else{

                $response = ['Register' => false, 'Error' => 'Campo email: Campo vacio'];
                die(json_encode($response));

            }

            //Validacion del campo password:
            if(!empty($data->password) && !empty($data->confirmPassword)){

                if($data->password == $data->confirmPassword){

                    $encryptePassword   = password_hash($data->password, PASSWORD_BCRYPT, ['cost' => 4]);
                    $verifyPassword     = password_verify($data->password, $encryptePassword);
                   
                    if($verifyPassword){
                        $validate['password'] = $encryptePassword;
                    }else{
                        $validate['password'] = 'Error de verificacion de hash.'; 
                    }

                }else{

                    $response = ['Register' => false, 'Error' => 'Campo password: Las contrasenias no coinciden.'];
                    die(json_encode($response));

                }
                
            }else{

                $register = ['Register' => false];
                $error = ['password' => 'Campo vacío'];
                $response = ['Register' => $register, 'Error' => $error];

                die(json_encode($response));

            }

            //Le damos un valor por defecto al campo sesion: 
            $validate['sesion'] = 'Inactiva';

            $response = ['Register' => true, 'fields' => $validate];

            return $response;

        }else{

            $response = ['Register' => false, 'Error' => 'No existen datos.'];
            die(json_encode($response));

        }
        
    }

    public function validateLogin(){

        if(isset($_SESSION['login'])){

            $data = $_SESSION['login'];

            $verifyPassword = password_verify($data->password, $data->confirmPassword);

            if($verifyPassword){

                $login = array('login' => true);
                return $login;

            }else{

                $login = array('login' => false, 'Error' => 'Contrasenia incorrecta');
                return $login;

            };

        }
        
    }

    public function recoverPassword(string $password, string $confirmPassword){

        $recoverdPassword = array();

        if($password == $confirmPassword){

            $encryptePassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);
            $verifyPassword   = password_verify($password, $encryptePassword);

            if($verifyPassword){

                $recoverdPassword['recoverdPassword'] = true;
                $recoverdPassword['newPassword'] = $encryptePassword;

                return $recoverdPassword;

            }else{

                $response = ['recoverdPassword' => false, 'Error' => 'No coincide el hash.'];
                die(json_encode($response));

            }

        }else{

            $response = ['recoverdPassword' => false, 'Error' => 'No coinciden las contrasenias.'];
            die(json_encode($response));
                
        }
    }
}