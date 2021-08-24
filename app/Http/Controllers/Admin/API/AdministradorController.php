<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Class\Administrador;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function validateData()
    {
        //Recibe los datos del modulo User: 
        $connect = new Administrador;
        $data = $connect->deliverConnect();

        //Realiza la validacion: 
        $admin = new Administrador(nombres: $data['nombres']['nombres'],
                                   apellido: $data['apellido']['apellido'],
                                   email: $data['email']['email'],
                                   password: $data['password']['password'],
                                   confirmPassword: $data['confirmPassword']['confirmPassword']);

                $_SESSION['sign-in'] = $admin;

                $register = $admin->validateData();

                if($register){
                    return $register;
                }else{
                    session_destroy($_SESSION['sign-in']);
                    $register;
                }     
                
    }

    public function validateLogin(){

        //Recibe los datos del modulo User: 
        $connect = new Administrador;
        $data = $connect->deliverConnect();
 
        //Realiza la validacion: 
        $admin = new Administrador(email: $data['email'],
                                   password: $data['password'],
                                   confirmPassword: $data['confirmPassword']);

                $_SESSION['login'] = $admin;

                $login = $admin->validateLogin();

                if($login){
                    return $login;
                }else{
                    session_destroy($_SESSION['login']);
                    $login;
                }

    }

    public function recoverdPassword()
    {

        //Recibe los datos del modulo User: 
        $connect = new Administrador;
        $data = $connect->deliverConnect();

        
        //Realiza la validacion: 
        $admin = new Administrador;

        $recoverdPassword = $admin->recoverdPassword(password: $data['password']['password'],
                                                     confirmPassword: $data['confirmPassword']['confirmPassword']);

        if($recoverdPassword){
                                                        
            return array('recoverdPassword' => $recoverdPassword['recoverdPassword']);
                            
        }else{
                            
            return $recoverdPassword;
                            
        }
 
    }

    public function closeSesion()
    {

        //Recibe los datos del modulo User: 
        $connect = new Administrador;
        $data = $connect->deliverConnect();
 
        //Realiza la validacion: 
        $admin = new Administrador;

        $closeSesion = $admin->closeSesion(closeSesion: $data);

        if($closeSesion){
            return $closeSesion;
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
