<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Api_setting;

class TestController extends Controller
{

    public  $newsApiName ='NewsAPI';
    public  $theGuardinApiName ='TheGuardian';
    public  $theNewYorkTimesApiName ='NewYorkTimes';


    public function commanTest(){

    return $this->newYorkTimesNewsSearch('Tesla');
        //return $this->theGuardianNewsSearch('Tesla');
     // return $this->newApiNewsSearch('Tesla');
        
    }



    //============================ The Guardian  Functions ===============================

    public function newYorkTimesNewsSearch($query,  $page='1'){

        $endPoint='search/v2/articlesearch.json';

        $data =  [
            'page' => $page,
            'q' => $query,

        ];

      //  business, entertainment, general, health, science, sports, technology

        $response = $this->useApi($this->theNewYorkTimesApiName, $endPoint, $data);
        $json = json_decode($response, true);;
        return $json;

    }
    

    //============================ The Guardian  Functions ===============================

    public function theGuardianNewsSearch($query,  $page='1'){

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

    //============================ News Api Functions ===============================


    public function newApiNewsSearch($query,  $sortBy='popularity',$language='en' ){

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
    
    public function newApiCategorySearch($category, $country='us',$language='en' ){

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

    public function newApiHeadline(){



        $endPoint= 'top-headlines';

        $data =  [
            'country' => 'us',
           // 'from'=>'2023-05-28',
        ];

        $response = $this->useApi($this->newsApiName, $authKey, $endPoint, $data);
        $json = json_decode($response, true);;
        return $json;

    }

  




    

   
    


    public function newYork(){

        // $response = Http::get('https://api.nytimes.com/svc/archive/v1/2019/1.json?api-key=dSnLS95ALgZkSSWGAgMrbKPw1bTGfs9C');
        // //  return response()->json(['success' => $response]);
        // $json = json_eecode($response, true);
        // return $json;

        $AuthApiKey= 'dSnLS95ALgZkSSWGAgMrbKPw1bTGfs9C';
        $response = Http::withHeaders([
           // 'X-First' => 'foo',
            'Authorization' => $AuthApiKey
        ])->get('https://api.nytimes.com/svc/archive/v1/2023/1.json', [
            //'country' => 'us',
            //'from'=>'2023-05-28',
            //'sortBy' => 'publishedAt',
            //'apiKey' => $AuthApiKey,
        ]);

      //  return $response;
        $json = json_decode($response, true);
        return $json;



        /* Direct Get Request

        $response = Http::get('https://newsapi.org/v2/everything?q=tesla&from=2023-04-30&sortBy=publishedAt&apiKey=21f5edcf45a84dc2b14b11140a392aac');
        //  return response()->json(['success' => $response]);
        $json = json_decode($response, true);
        return $json;




        /* Post Sample


            $response = Http::post('http://example.com/users', [
                'name' => 'Steve',
                'role' => 'Network Administrator',
            ]);



        */
      
    }
    

    public function index(){

        $AuthApiKey= '21f5edcf45a84dc2b14b11140a392aac';
        $response = Http::withHeaders([
           // 'X-First' => 'foo',
            'Authorization' => $AuthApiKey
        ])->get('https://newsapi.org/v2/top-headlines', [
            'country' => 'us',
            'from'=>'2023-02-12',
            //'sortBy' => 'publishedAt',
            //'apiKey' => $AuthApiKey,
        ]);

      //  return $response;
        $json = json_decode($response, true);
        return $json;



        /* Direct Get Request

        $response = Http::get('https://newsapi.org/v2/everything?q=tesla&from=2023-04-30&sortBy=publishedAt&apiKey=21f5edcf45a84dc2b14b11140a392aac');
        //  return response()->json(['success' => $response]);
        $json = json_decode($response, true);
        return $json;




        /* Post Sample


            $response = Http::post('http://example.com/users', [
                'name' => 'Steve',
                'role' => 'Network Administrator',
            ]);



        */
      
    }


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
        if($apiName!=='NewsAPI'){
             $data['api-key']=$authKey; // adding apikey in data for the guardin API
        }
        $response = Http::withHeaders([
            'Authorization' => $authKey
        ])->get($apiUrl, $data);
        
        return $response;
  
    }


}