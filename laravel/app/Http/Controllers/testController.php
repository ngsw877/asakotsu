<?php

namespace App\Http\Controllers;

use App\Traits\ZoomJWT;
use Illuminate\Http\Request;

class testController extends Controller
{
    use ZoomJWT;

    public function callSendPost(){


        $this->sendPost();
    }


    // public function callSendPost(string $path1){


    //     $path2 = array('query1' => 'value1', 'query2' => 'value2');
    //     $this->sendPost($path1, $path2 );
    // }


}
