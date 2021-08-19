<?php

namespace App\Http\Controllers\Require\Connect;

class Connect{

    private $data;

    public function __construct(){}

    public function receiveData($receiveData)
    {
        $this->data = $receiveData;
    }

    public function deliverData()
    {
        return $this->data;
    }
}