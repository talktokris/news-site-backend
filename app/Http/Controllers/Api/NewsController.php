<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\GuardianApiController;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Api\NewYorkApiController;

class NewsController extends Controller
{
    //

    public function commanTest(){


        $this->guardinReformatArray();

    //    return GuardianApiController::theGuardianHomeNews();

   
       // echo $newsData['response']['status'];
        // echo "<pre>";
        // print_r($newsData);
        // echo "</pre>";

       // return $newsData;
    }
    public function guardinReformatArray(){

        $theGuardin = new GuardianApiController();
      //  $newsData= $theGuardin->theGuardianHomeNews();

             // return $this->theGuardianCategorySearch('');
  
       // return $this->theGuardianNewsSearch('Krishna');
   
      $newsData= $theGuardin->theGuardianCategorySearch('Travel');
    // dd($newsData);

        if(isset($newsData['response']['results'])){
            $resultData = $newsData['response']['results'];

           // dd($resultData);

            foreach($resultData as $item){

               // dd($item);
                $id=$item['id'];
                $title=$item['webTitle'];
               // $image = $item['fields']['thumbnail'];
                if(isset($item['fields'][0]['thumbnail'])){  $image=$item['fields']['thumbnail'];  } else {  $image='';}
                if(isset($item['fields']['shortUrl'])){  $link=$item['fields']['shortUrl'];  } else {  $link='';}

               // $link = $item['fields']['shortUrl'];
                $categoryId=$item['sectionId'];
                $categoryName=$item['sectionName'];
                if(isset($item['tags'][0]['type'])){  $autherProfie=$item['tags'][0]['type'];  } else {  $autherProfie='';}

                if(isset($item['tags'][0]['webTitle'])){   $authorName=$item['tags'][0]['webTitle']; } else {  $authorName='';}
                $date=$item['webPublicationDate'];
        
           // dd($setArray);


            $newSetArray[]= $this->newArray($id, $title, 'The Guardin', $image, $link, $categoryId, $categoryName, $autherProfie, $authorName, $date);
            }
            dd($newSetArray);
        }

      //  echo count($newsData['response']);

    }


    public function newArray($id, $title, $source, $image, $link, $categoryId, $categoryName, $autherProfie, $authorName, $date){

        return  [   'id'=>$id,
                    'title'=>$title,
                    'source'=>'The Guardin',
                    'image'=>$image,
                    'link'=>$link,
                    'categoryId'=>$categoryId,
                    'categoryName'=>$categoryName,
                    'autherProfie'=>$autherProfie,
                    'authorName'=>$authorName,
                    'date'=>$date,
                ];
        
    }
    
    public function guardinReformatArray2(){

        $theGuardin = new GuardianApiController();
        $newsData= $theGuardin->theGuardianHomeNews('Travel');
        dd($newsData);


        if(isset($newsData['response']['results'])){
            $resultData = $newsData['response']['results'];

            foreach($resultData as $item){

                dd($item);
            }
         //   dd($resultData);
        }

      //  echo count($newsData['response']);

    }
}