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
        $user = Usuario::all();
        return $user;
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
        $data = ['nombres' => $request->all('nombres'),
                 'apellido' => $request->all('apellido'),
                 'email' => $request->all('email'),
                 'password' => $request->all('password'),
                 'confirmPassword' => $request->all('confirmPassword'),
                 'rol_id' => $request->all('rol_id'),];

        //Validar el rol:
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

            default:
             echo "'Rol_id' incorrecto";
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
