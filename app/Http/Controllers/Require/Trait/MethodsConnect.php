<?php
namespace App\Http\Controllers\Require\Trait;

use App\Http\Controllers\Require\Connect\Connect;

trait MethodsConnect{

    public function receiveConnect($data)
    {

        $connect = new Connect;
        $connect->receiveData($data);
        $_SESSION['connect'] = $connect;

    }

    public function deliverConnect()
    {

        if(isset($_SESSION['connect'])){

            $connect = $_SESSION['connect'];
            return $connect->deliverData();

        }

    }

}