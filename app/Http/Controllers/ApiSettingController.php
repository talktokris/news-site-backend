<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Api_setting;

class ApiSettingController extends Controller
{
  public function fetchApiSettings(){

    $apiData= Api_setting::get();

 //   dd($apiData);
    return view("apiPage")->with(compact('apiData'));

  }
}