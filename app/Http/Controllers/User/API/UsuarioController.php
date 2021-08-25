<?php

namespace App\Http\Controllers\User\API;

use App\Http\Controllers\User\Class\Cliente;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\API\AdministradorController;
use App\Models\Direccion;
use App\Models\Usuario;
use App\Models\Rol;
use DateTime;
use Illuminate\Http\Request; 
use App\Mail\RecoverdPassword;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{

    public function prueba()
    {
        $data = array('nombres' => true);
        

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "sdgklasgdhjksdhgaljks";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //Recibir datos:
        $data = ['form' => $request->all('form'),
                 'nombres' => $request->all('nombres'),
                 'apellido' => $request->all('apellido'),
                 'email' => $request->all('email'),
                 'password' => $request->all('password'),
                 'confirmPassword' => $request->all('confirmPassword'),
                 'rol_id' => $request->all('rol_id'),
                 'closeLogin' => $request->all('closeLogin')];


        //Validamos de cual formulario vienen los datos: 
        switch($data['form']['form']){

            //Formulario de registro:
            case 'sign-in': 

                 //Insertamos los roles por primera vez en la tabla 'rols': 
                $roleClient = Rol::where('id_rol', '=', 1)->first();
                $roleAdmin  = Rol::where('id_rol', '=', 2)->first();

                if($data['rol_id']['rol_id'] == 1){

                    if(!$roleClient){
                        Rol::create(['nombre_rol' => 'Cliente']);
                        Rol::create(['nombre_rol' => 'Administrador']);
                    }

                }elseif($data['rol_id']['rol_id'] == 2){

                    if(!$roleClient && !$roleAdmin){

                        Rol::create(['nombre_rol' => 'Cliente']);
                        Rol::create(['nombre_rol' => 'Administrador']);

                    }

                }

                //Validamos el rol del usuario en el sistema:
                switch($data['rol_id']['rol_id']){

                    //Rol de cliente:
                    case 1:

                        $model = Usuario::where('email', '=', $data['email']['email']);
                        $validate = $model->first();

                        if(!$validate){

                            $client = new Cliente(nombres: $data['nombres']['nombres'],
                            apellido: $data['apellido']['apellido'],
                            email: $data['email']['email'],
                            password: $data['password']['password'],
                            confirmPassword: $data['confirmPassword']['confirmPassword'],
                            rol_id: $data['rol_id']['rol_id']);

                            $_SESSION['sign-in'] = $client;
                            $register = $client->validateData();

                            if($register){
                                $post = $request->except(['password', 'confirmPassword']);
                                $post['password'] = $register['fields']['password'];
                                $post['sesion'] = $register['fields']['sesion'];
                                Usuario::create($post);
                                return $register;
                            }else{
                                session_destroy($_SESSION['sign-in']);
                                $register;
                            }

                        }else{

                            $register = ['Register' => false, 'Error' => 'Este usuario ya existe en la base de datos.'];
                            return $register;
                        }

                    break;

                    //Rol de administrador:
                    case 2:

                        $model = Usuario::where('email', '=', $data['email']['email']);
                        $validate = $model->first();

                        if(!$validate){
                            
                            //Envio los datos al modulo Admin: 
                            $connect = new Cliente;
                            $connect->receiveConnect($data);

                            //Recibimos la respuesta del modulo Admin: 
                            $admin = new AdministradorController;
                            $register =  $admin->validateData();

                            if($register){
                                $post = $request->except(['password', 'confirmPassword']);
                                $post['password'] = $register['fields']['password'];
                                $post['sesion'] = $register['fields']['sesion'];
                                Usuario::create($post);
                                return $register;
                            }else{
                                $register;
                            }

                        }else{

                            $register = ['Register' => false, 'Error' => 'Este usuario ya existe en la base de datos.'];
                            return $register;
                            
                        }
                        
                    break;

                    default:
                        $error = array('Error' => "'rol_id' no valido.");
                        return $error;
                    break;

                }

            break;

            //Formulario de Inicio de sesion: 
            case 'login':
                
                //Validamos el rol del usuario en el sistema:
                switch($data['rol_id']['rol_id']){

                    //Rol de cliente:
                    case 1:

                        $model = Usuario::where('email', '=', $data['email']['email']);
                        $validate = $model->first();

                        if($validate){

                            $client = new Cliente(password: $data['password']['password'],
                                                  confirmPassword: $validate['password']);

                            $_SESSION['login'] = $client;

                            $login = $client->validateLogin();

                            if($login){
                                $model->update(['sesion' => 'Activa']);
                                setcookie('email', $validate['email']);
                                return $login;
                            }else{
                                unset($_SESSION['login']);
                                return $login;
                            }

                        }else{             

                            $login = array('login' => false, 'Error' => 'Email incorrecto.');
                            if(!$login){
                                unset($_SESSION['login']);
                            }
                            return $login;
                        }
                    
                    break;

                    //Rol de administrador:
                    case 2:

                        $model = Usuario::where('email', '=', $data['email']['email']);
                        $validate = $model->first();

                        if($validate){

                            //Envio los datos al modulo Admin: 
                            $connect = new Cliente;
                            $sendData = ['email' => $data['email']['email'],
                                         'password' => $data['password']['password'], 
                                         'confirmPassword' => $validate['password']];


                            $connect->receiveConnect($sendData);
    
                            //Recibimos la respuesta del modulo Admin: 
                            $admin = new AdministradorController;
                            $login =  $admin->validateLogin();

                            if($login){
                                $model->update(['sesion' => 'Activa']);
                                setcookie('email', $validate['email']);
                                return $login;
                            }else{
                                return $login;
                            }
                        }

                    break;

                    default:
                        $error = array('Error' => "'rol_id' no valido.");
                        return $error;
                    break;

                }

            break;

            //Cerrar la sesion del usuario en el sistema: 
            case 'closeLogin': 

                //Validamos el rol del usuario en el sistema: 
                switch($data['rol_id']['rol_id']){

                    //Rol de cliente: 
                    case 1: 

                        $model = Usuario::where('email', '=', $data['email']['email']);
                        $validate = $model->first();

                        if($validate){

                            if($validate['sesion'] == 'Activa'){
                                
                                $client = new Cliente;
                                $closeSesion = $client->closeSesion(closeSesion: $data['closeLogin']['closeLogin']);
        
                                if($closeSesion){
        
                                    $model->update(['sesion' => 'Inactiva']);
                                    return $closeSesion;
    
                                }else{
    
                                    $error = ['Error' => 'No se pudo cerrar la sesion.'];
                                    return $error;
                                }

                            }else{

                                $error = ['Error' => 'Este usuario no ha iniciado sesion.'];
                                return $error;

                            }

                        }else{

                            $error = array('Error' => 'No existe este usuario.');
                            return $error;

                        }
                       
                    break;

                    //Rol de administrador: 
                    case 2: 

                        $model = Usuario::where('email', '=', $data['email']['email']);
                        $validate = $model->first();

                        if($validate){ 

                            if($validate['sesion'] == 'Activa'){

                                //Envio los datos al modulo Admin: 
                                $connect = new Cliente;
                                $connect->receiveConnect($data['closeLogin']['closeLogin']);

                                //Recibimos la respuesta del modulo Admin: 
                                $admin = new AdministradorController;
                                $closeSesion =  $admin->closeSesion();

                                if($closeSesion){
                
                                    $model->update(['sesion' => 'Inactiva']);
                                    return $closeSesion;

                                }else{

                                    $error = array('Error' => 'No se pudo cerrar la sesion.');
                                    return $error;
                                }

                            }else{

                                $error = ['Error' => 'Este usuario no ha iniciado sesion.'];
                                return $error;

                            }

                        }else{

                            $error = ['Error' => 'No existe este usuario.'];
                            return $error;

                        }

                    break;
                }

            break;
            
            default:
                $error = array('Error' => 'Formulario no valido.');
                return $error;
            break;

        }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = array('form' => $request->all('form'),
                      'nombres' => $request->all('nombres'),
                      'apellido' => $request->all('apellido'),
                      'email' => $request->all('email'),
                      'password' => $request->all('password'),
                      'confirmPassword' => $request->all('confirmPassword'),
                      'rol_id' => $request->all('rol_id'),
                      'calle' => $request->all('calle'),
                      'departamento' => $request->all('departamento'),
                      'municipio' => $request->all('municipio'),
                      'codigo_postal' => $request->all('codigo_postal'));

        switch($data['form']['form']){

            //Formulario de actualizacion de datos del usuario: 
            case 'updateUser': 

                //Validamos el rol del usuario en el sistema: 
                switch($data['rol_id']['rol_id']){

                    //Rol de cliente: 
                    case 1: 

                        $model = Usuario::where('email', '=', $data['email']['email']);
                        $validate = $model->first();

                        if($validate){

                            $client = new Cliente(nombres: $data['nombres']['nombres'],
                                              apellido: $data['apellido']['apellido'],
                                              email: $data['email']['email'],
                                              password: $data['password']['password'],
                                              confirmPassword: $data['confirmPassword']['confirmPassword']);
                                            
                            $_SESSION['sign-in'] = $client;

                            $updateUser = $client->validateData();

                            if($updateUser){

                                $model->update(['nombres' => $data['nombres']['nombres'],
                                                'apellido' => $data['apellido']['apellido'],
                                                'email' => $data['email']['email'],
                                                'password' => $updateUser['fields']['password']]);

                                $insert = ['calle' => $data['calle']['calle'],
                                           'departamento' => $data['departamento']['departamento'],
                                           'municipio' => $data['municipio']['municipio'],
                                           'codigo_postal' => $data['codigo_postal']['codigo_postal'],
                                           'usuario_id' => $validate['id_usuario']]; 

                                Direccion::create($insert);

                                return array('Register' => $updateUser['Register'], 'fields' => $updateUser['fields']);

                            }else{

                                return $updateUser;

                            }
                            
                        }else{

                            $error = array('Error' => 'No existe este usuario.');
                            return $error;

                        }

                    break;

                    //Rol de administrador: 
                    case 2: 

                        $model = Usuario::where('email', '=', $data['email']['email']);
                        $validate = $model->first();

                        if($validate){

                            //Envio los datos al modulo Admin: 
                            $connect = new Cliente;
                            $connect->receiveConnect($data);
 
                            //Recibimos la respuesta del modulo Admin: 
                            $admin = new AdministradorController;
                            $updateUser =  $admin->validateData();
 
                            if($updateUser){

                                $model->update(['nombres' => $data['nombres']['nombres'],
                                                'apellido' => $data['apellido']['apellido'],
                                                'email' => $data['email']['email'],
                                                'password' => $updateUser['fields']['password']]);

                                $insert = ['calle' => $data['calle']['calle'],
                                            'departamento' => $data['departamento']['departamento'],
                                            'municipio' => $data['municipio']['municipio'],
                                            'codigo_postal' => $data['codigo_postal']['codigo_postal'],
                                            'usuario_id' => $validate['id_usuario']]; 
     
                                Direccion::create($insert);

                                return array('Register' => $updateUser['Register'], 'fields' => $updateUser['fields']);

                            }else{

                                return $updateUser;

                            }
                            
                        }else{

                            $error = array('Error' => 'No existe este usuario.');
                            return $error;

                        }

                    break;

                    default: 

                        $error = array('Error' => "'rol_id' no valido.");
                        return $error;

                    break;
                }

            break;

            //Formulario para restablecer contrasenia: 
            case 'recoverdPassword': 

                 //Validamos el rol del usuario en el sistema: 
                switch($data['rol_id']['rol_id']){

                    //Rol de cliente: 

                    case 1: 

                        $model = Usuario::where('email', '=', $data['email']['email']);
                        $validate = $model->first();

                        $currentDate = new DateTime();

                        //Solicitud inicial de restablecimiento: 
                        if($validate['sesion'] == 'Inactiva'){

                            $model->update(['sesion' => 'Pendiente']);

                            $dateOfExpire = date('Y-m-d H:i:s', strtotime($validate['updated_at']. '+10 minutes'));

                            //Envio el email de restablecimiento: 
                            $email = new RecoverdPassword;

                            Mail::to($validate['email'])->send($email);

                            //valido la fecha actual con la de expiracion: 
                            if($currentDate->format('Y-m-d H:i:s') != $dateOfExpire){

                                $client = new Cliente();
                                $recoverdPassword = $client->recoverPassword(password: $data['password']['password'],
                                                                             confirmPassword: $data['confirmPassword']['confirmPassword']);
        
                                if($recoverdPassword){
        
                                    $model->update(['password' => $recoverdPassword['newPassword']]);
                                    return array('recoverdPassword' => $recoverdPassword['recoverdPassword']);
        
                                }else{
        
                                    return $recoverdPassword;
        
                                }

                            }

                         //Solicitud final de restablecimiento: 
                        }elseif($validate['sesion'] == 'Pendiente'){

                            $dateOfExpire = date('Y-m-d H:i:s', strtotime($validate['updated_at']. '+10 minutes'));

                            //valido la fecha actual con la de expiracion: 
                            if($currentDate->format('Y-m-d H:i:s') == $dateOfExpire){

                                $model->update(['sesion' => 'Inactiva']);
                                $recoverdPassword = ['recoverdPassword' => false, 'Error' => 'Ha excedido el tiempo limite de espera.'];
                                return $recoverdPassword;

                            }
                            
                        }else{
        
                            $error = array('recoverdPassword' => false, 'Error' => 'Este usuario ya inicio sesion en el sistema.');
                            return $error;
        
                        }

                    break;

                    //Rol de administrador: 
                    case 2: 

                        $model = Usuario::where('email', '=', $data['email']['email']);
                        $validate = $model->first();

                        $currentDate = new DateTime();

                        //Solicitud inicial de restablecimiento: 
                        if($validate['sesion'] == 'Inactiva'){

                            $model->update(['sesion' => 'Pendiente']);

                            $dateOfExpire = date('Y-m-d H:i:s', strtotime($validate['updated_at']. '+10 minutes'));

                            //Envio el email de restablecimiento: 
                            $email = new RecoverdPassword;

                            Mail::to($validate['email'])->send($email);

                            //valido la fecha actual con la de expiracion: 
                            if($currentDate->format('Y-m-d H:i:s') != $dateOfExpire){

                                //Envio los datos al modulo Admin: 
                                $client = new Cliente;
                                $client->receiveConnect($data);

                                //Recibimos la respuesta del modulo Admin: 
                                $admin = new AdministradorController;
                                $recoverdPassword = $admin->recoverPassword();
        
                                if($recoverdPassword){
        
                                    $model->update(['password' => $recoverdPassword['newPassword']]);
                                    return array('recoverdPassword' => $recoverdPassword['recoverdPassword']);
        
                                }else{
        
                                    return $recoverdPassword;
        
                                }

                            }

                         //Solicitud final de restablecimiento: 
                        }elseif($validate['sesion'] == 'Pendiente'){

                            $dateOfExpire = date('Y-m-d H:i:s', strtotime($validate['updated_at']. '+10 minutes'));

                            //valido la fecha actual con la de expiracion: 
                            if($currentDate->format('Y-m-d H:i:s') == $dateOfExpire){

                                $model->update(['sesion' => 'Inactiva']);
                                $recoverdPassword = ['recoverdPassword' => false, 'Error' => 'Ha excedido el tiempo limite de espera.'];
                                return $recoverdPassword;

                            }
                            
                        }else{
        
                            $error = array('recoverdPassword' => false, 'Error' => 'Este usuario ya inicio sesion en el sistema.');
                            return $error;
        
                        }

                    break;

                    default: 

                        $error = array('Error' => "'rol_id' no valido.");
                        return $error;

                    break;
                }

            break;

            default: 

                $error = array('Error' => 'Formulario no valido.');
                return $error;

            break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
