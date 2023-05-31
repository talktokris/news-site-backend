<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController;

class NewsApiController extends BaseApiController
{

    public function commanTest(){
        return $this->newApiNewsSearch('Travel');
    }

    public  function newApiNewsSearch($query,  $sortBy='popularity',$language='en' ){

        $endPoint='everything';

        $data =  [
            'language' => $language,
            'sortBy' => $sortBy,
            'q' => $query,

        ];

      //  business, entertainment, general, health, science, sports, technology

        $response = $this->useApi($this->newsApiName, $endPoint, $data);
        $json = json_decode($response, true);;
        return $json;

    }
    
    public static function newApiCategorySearch($category, $country='us',$language='en' ){

        $endPoint='sources';

        $data =  [
            'country' => $country,
            'language' => $language,
            'category' => $category,
        ];

      //  business, entertainment, general, health, science, sports, technology

        $response = $this->useApi($this->newsApiName, $endPoint, $data);
        $json = json_decode($response, true);;
        return $json;

    }

    public static function newApiHeadline(){



        $endPoint= 'top-headlines';

        $data =  [
            'country' => 'us',
           // 'from'=>'2023-05-28',
        ];

        $response = $this->useApi($this->newsApiName, $authKey, $endPoint, $data);
        $json = json_decode($response, true);;
        return $json;

    }

}