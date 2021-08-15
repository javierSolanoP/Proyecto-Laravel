<?php
namespace App\Http\Controllers\Require\Trait;

session_start();
trait MethodsUser{

    public function registerData(){
        
        if(isset($_SESSION['user'])){

            $data = $_SESSION['user'];
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

            $response = ['Register' => true, 'fields' => $validate];

            return $response;

        }else{

            $response = ['Register' => false, 'Error' => 'No existen datos.'];
            die(json_encode($response));

        }
        
    }

    public function validateLogin(){

        if(isset($_SESSION['client'])){

            $data = $_SESSION['client'];

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

    public function recoverPassword(){

        //Revisamos el directorio: 
        if(!is_dir('email')){
            mkdir('email', 0777) or die(json_encode(['Error' => 'No se pudo crear la carpeta.']));
        }else{
            die(json_encode(['Error' => 'Ya existe la carpeta']));
        }

        //Revisamos los archivos del directorio:
        if($directory = opendir('./email')){
            while(false != ($file = readdir($directory))){
                echo $file;
            }
            
        }else{
            echo json_encode('ddd');
        }
    }
    public function updateData(){}

}