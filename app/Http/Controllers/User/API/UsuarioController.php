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

        $client->recoverPassword();
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

                    case 1:

                        $client = new Cliente(nombres: $data['nombres']['nombres'],
                                  apellido: $data['apellido']['apellido'],
                                  email: $data['email']['email'],
                                  password: $data['password']['password'],
                                  confirmPassword: $data['confirmPassword']['confirmPassword'],
                                  rol_id: $data['rol_id']['rol_id']);

                                  $_SESSION['user'] = $client;
                                  $register = $client->registerData();

                                  if($register){
                                      $post = $request->except(['password', 'confirmPassword']);
                                      $post['password'] = $register['fields']['password'];
                                      Usuario::create($post);
                                      return $register;
                                  }else{
                                      $register;
                                  }
                    break;

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

                    case 1:

                        $model = Usuario::where('email', '=', $data['email']['email'])->first();

                        if($model){

                            $client = new Cliente(password: $data['password']['password'],
                                                  confirmPassword: $model['password']);

                            $_SESSION['client'] = $client;

                            $login = $client->validateLogin();
                            return $login;

                        }else{

                            $login = array('login' => false, 'Error' => 'Email incorrecto.');
                            return $login;

                        }
                    
                    break;

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
        //
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
