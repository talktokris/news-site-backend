<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController;


class NewYorkApiController extends BaseApiController
{

    public  function commanTest(){
        return $this->newYorkTimesHomeNews();
    }

    
    public  function newYorkTimesCategorySearch($category,  $limit=10, $offset=0){

        if($category!=''){

            $catData =  News_category::where('label','=', $category)->where('news_source_id','=', 3)->get()->toArray();
                    if(count($catData)<1){ 
                        return null;
                        }
                    else{
                        $jsonFileName= $catData[0]['name'].'.json';
                    }
        }
        else { $jsonFileName='all.json'; }

        

            $endPoint='news/v3/content/all/'.$jsonFileName; 

            $data =  [
                'limit' => $limit,
                'offset'=>$offset
            ];


            $response = $this->useApi($this->theNewYorkTimesApiName, $endPoint, $data);
            $json = json_decode($response, true);
            return $json;

    }

    public  function newYorkTimesNewsSearch($query,  $page='1',  $sort='newest'){

        $endPoint='search/v2/articlesearch.json';

        $data =  [
            'page' => $page,
            'q' => $query,
            'sort'=>$sort,

        ];

      //  business, entertainment, general, health, science, sports, technology

        $response = $this->useApi($this->theNewYorkTimesApiName, $endPoint, $data);
        $json = json_decode($response, true);;
        return $json;

    }

    public  function newYorkTimesHomeNews(){

        $endPoint='topstories/v2/home.json';

        $data =  [];

        $response = $this->useApi($this->theNewYorkTimesApiName, $endPoint, $data);
        $json = json_decode($response, true);;
        return $json;

    }
    
}