<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Class\Administrador;


class AdministradorController extends Controller
{
    public function receiveData()
    {
        $admin = new Administrador;

        return $admin->deliverConnect();
    }
}
