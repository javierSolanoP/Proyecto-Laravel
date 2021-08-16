<?php

namespace App\Http\Controllers\User\API;

use App\Http\Controllers\User\Class\Cliente;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request; 

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
        $client = new Cliente();

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
                 'rol_id' => $request->all('rol_id'),];


        //Validamos de cual formulario vienen los datos: 
        switch($data['form']['form']){

            //Formulario de registro:
            case 'sign-in': 

                //Validamos el rol del usuario en el sistema:
                switch($data['rol_id']['rol_id']){

                    //Rol de cliente:
                    case 1:

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
                                      Usuario::create($post);
                                      return $register;
                                  }else{
                                      session_destroy($_SESSION['sign-in']);
                                      $register;
                                  }
                    break;

                    //Rol de administrador:
                    case 2:
                        //Modulo administrador
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

                        $model = Usuario::where('email', '=', $data['email']['email'])->first();

                        if($model){

                            $client = new Cliente(password: $data['password']['password'],
                                                  confirmPassword: $model['password']);

                            $_SESSION['login'] = $client;

                            $login = $client->validateLogin();

                            if($login){
                                return $login;
                            }else{
                                session_destroy($_SESSION['login']);
                                return $login;
                            }

                        }else{             

                            $login = array('login' => false, 'Error' => 'Email incorrecto.');
                            if(!$login){
                                session_destroy($_SESSION['login']);
                            }
                            return $login;
                        }
                    
                    break;

                    //Rol de administrador:
                    case 2:
                        //Modulo administrador
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
    public function update(Request $request, Usuario $usuario)
    {
        $data = array('form' => $request->all('form'),
                      'nombres' => $request->all('nombres'),
                      'apellido' => $request->all('apellido'),
                      'email' => $request->all('email'),
                      'password' => $request->all('password'),
                      'confirmPassword' => $request->all('confirmPassword'),
                      'rol_id' => $request->all('rol_id'));

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

                        if($validate){

                            $client = new Cliente(email: $data['email']['email'],
                                              password: $data['password']['password'],
                                              confirmPassword: $data['confirmPassword']['confirmPassword']);
                                            
                            $_SESSION['recoverdPassword'] = $client;

                            $recoverdPassword = $client->recoverPassword();

                            if($recoverdPassword){

                                $model->update(['password' => $recoverdPassword['newPassword']]);
                                return array('recoverdPassword' => $recoverdPassword['recoverdPassword']);

                            }else{

                                return $recoverdPassword;

                            }
                            
                        }else{

                            $error = array('Error' => 'No existe este usuario.');
                            return $error;

                        }

                    break;

                    //Rol de administrador: 
                    case 2: 

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
