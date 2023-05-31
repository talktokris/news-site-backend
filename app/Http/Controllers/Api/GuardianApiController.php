<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\News_category;


class GuardianApiController extends BaseApiController
{


    public  function commanTest(){
       // dd("hi");
      //  return $this->theGuardianHomeNews('');

     // return $this->theGuardianNewsSearch('');
    }

    
    public  function theGuardianHomeNews($page=1){


        $endPoint='world'; 

    $data =  [
        'page' => 1,
        //'show-elements'=>'image',
        'show-tags'=>'contributor',
        'show-fields'=>'starRating,headline,thumbnail,short-url',

    ];

  //  business, entertainment, general, health, science, sports, technology

    $response = $this->useApi($this->theGuardinApiName, $endPoint, $data);
    $json = json_decode($response, true);;
    return $json;

}

public  function theGuardianCategorySearch($category,  $page=1){
  

    if($category!=''){

        $catData =  News_category::where('label','=', $category)->where('news_source_id','=', 2)->get()->toArray();
      // dd($catData) ;   
        if(count($catData)<1){ 
                    return [];
                    }
                else{
                    $category_name= $catData[0]['name'];
                }
    }
    else { $category_name='world'; }

    

        $endPoint=$category_name; 

    $data =  [
        'page' => $page,
      

    ];

  //  business, entertainment, general, health, science, sports, technology

    $response = $this->useApi($this->theGuardinApiName, $endPoint, $data);
    $json = json_decode($response, true);;
    return $json;

}

public  function theGuardianNewsSearch($query,  $page='1'){

    $endPoint='search';

    $data =  [
        'page' => $page,
        'q' => $query,

    ];

  //  business, entertainment, general, health, science, sports, technology

    $response = $this->useApi($this->theGuardinApiName, $endPoint, $data);
    $json = json_decode($response, true);;
    return $json;

}
}