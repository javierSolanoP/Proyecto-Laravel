<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Mail\RecoverdPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail(){
        
        $details = [
            'title' => 'Restablecer contraseña',
            'body'  => 'Email para restablecer contraseña'
        ];

        Mail::to('')->send(new RecoverdPassword($details));
        return "Enviado";
    }
}
