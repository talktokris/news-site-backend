<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Api_setting;
use App\Models\News_category;

class BaseApiController extends Controller
{


    public  $newsApiName ='NewsAPI';
    public  $theGuardinApiName ='TheGuardian';
    public  $theNewYorkTimesApiName ='NewYorkTimes';
   
    public function apiInfo($name){

        $data = Api_setting::where('status','=', 1)->where('name','=',$name)->get()->toArray();
      
        if(count($data)>=1){
            $objectData = (object) $data[0];
        } else {
           $objectData = (object) ['api_url'=>'', 'api_key'=>''];
        }
        return $objectData;
    
    }

    

    public function useApi($apiName, $endPoint, $data){
    
        $apiData = $this->apiInfo($apiName); // NewsAPI , NewYorkTimes, TheGuardian
        $authKey = $apiData->api_key; // Auth Key from database
        $baseUrl = $apiData->api_url; // Endpoint base url
        $apiUrl= $baseUrl . '/'. $endPoint;

      //  dd($authKey);
      
        if($apiName!=='NewsAPI'){
             $data['api-key']=$authKey; // adding apikey in data for the guardin API
        }
        $response = Http::withHeaders([
            'Authorization' => $authKey
        ])->get($apiUrl, $data);
        
      //  dd($response);
        return $response;
  
    }

}