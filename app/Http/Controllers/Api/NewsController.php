<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\NewYorkApiController;
use App\Http\Controllers\Api\GuardianApiController;
use App\Http\Controllers\Api\SettingsController;


class NewsController extends Controller
{
    //

    public function commanTest(){

      dd(hi);

        //Filter Setting Data Fatching for API
        $newsSetting  = new SettingsController();
        $filterSettings =$newsSetting->getNewsSeettings();

       //Latest News Data Fatching for API
        $dataNewYork = $this->newYorkTimesReformatArray();
        $dataNewsApi = $this->newsApiReformatArray();
        $dataGuardin= $this->guardinReformatArray();
        $dataAll = array_merge($dataNewYork,$dataNewsApi, $dataGuardin);
        shuffle($dataAll);

        //available News Date Filter Setup

        $dates = array_column($dataAll,'date_human');
        $uiniqueDates = array_unique($dates);
       // dd($uiniqueDates);

        return response()->json([
          'status' => 'success',
          'filterSettings' => $filterSettings,
          'filterDates'=>$uiniqueDates,
          'newsData' => $dataAll,
          //'authors' => NewsAuthorResource::collection($newAuthorData),
     
      ]);
      
    //   dd($dataAll);
    
    //    return GuardianApiController::theGuardianHomeNews();


       // return $newsData;
    }

    public function homePage(){
       //Filter Setting Data Fatching for API
       $newsSetting  = new SettingsController();
       $filterSettings =$newsSetting->getNewsSeettings();

      //Latest News Data Fatching for API
       $dataNewYork = $this->newYorkTimesReformatArray();
       $dataNewsApi = $this->newsApiReformatArray();
       $dataGuardin= $this->guardinReformatArray();
       $dataAll = array_merge($dataNewYork,$dataNewsApi, $dataGuardin);
       shuffle($dataAll);

       //available News Date Filter Setup

       $dates = array_column($dataAll,'date_human');
       $uiniqueDates = array_unique($dates);
      // dd($uiniqueDates);

       return response()->json([
         'status' => 'success',
         'filterSettings' => $filterSettings,
         'filterDates'=>$uiniqueDates,
         'newsData' => $dataAll,
         //'authors' => NewsAuthorResource::collection($newAuthorData),
    
     ]);
    }

    public function newYorkTimesReformatArray(){

        $newYorkObj = new NewYorkApiController();

      //  dd($newsApi->newsApiName);
            //  $newsData= $theGuardin->theGuardianHomeNews();
            // return $this->theGuardianCategorySearch('');
            // return $this->theGuardianNewsSearch('Krishna');
            //  $newsData= $theGuardin->theGuardianCategorySearch('Travel');

        $newsData= $newYorkObj->newYorkTimesHomeNews();
        // dd($newsData);
         
        if(isset($newsData['results'])){
     
            $resultData = $newsData['results'];
          //  dd($resultData);
        
          $newSetArray=[];
            foreach($resultData as $item){
              //  dd($item);
                $id=$item['url'];
                $title=$item['title'];
                if(isset($item['multimedia'][0]['url'])){  $image=$item['multimedia'][0]['url'];  } else {  $image='';}
                if(isset($item['short_url'])){  $link=$item['short_url'];  } else {  $link='';}
                if(isset($item['abstract'])){  $content=$item['abstract'];  } else {  $content=''; }
                $categoryId=$item['section'];
                $categoryName=$item['subsection'];
                if(isset($item['byline'])){  $autherProfie=$item['byline'];  } else {  $autherProfie='';}
                if(isset($item['byline'])){   $authorName=$item['byline']; } else {  $authorName='';}
                $date=$item['published_date'];
               // if(isset($item['source'])){   $sourceName=$item['source']['name']; } else {  $sourceName='New York Times';}
                $sourceName='New York Times';
           // dd($setArray);
            $newSetArray[]= $this->newArray($id, $title, $sourceName, $image, $content, $link, $categoryId, $categoryName, $autherProfie, $authorName, $date);
         
           
          }
          //  dd($newSetArray);

           return $newSetArray;
          
        }
      //  echo count($newsData['response']);
    

    }

    public function newsApiReformatArray(){

        $newsApiObj = new NewsApiController();

      //  dd($newsApi->newsApiName);
            //  $newsData= $theGuardin->theGuardianHomeNews();
            // return $this->theGuardianCategorySearch('');
            // return $this->theGuardianNewsSearch('Krishna');
            //  $newsData= $theGuardin->theGuardianCategorySearch('Travel');

        $newsData= $newsApiObj->newApiNewsHome();
       //  dd($newsData);
         
        if(isset($newsData['articles'])){
     
            $resultData = $newsData['articles'];
          //  dd($resultData);
        
          $newSetArray=[];
            foreach($resultData as $item){
              //  dd($item);
                $id=$item['url'];
                $title=$item['title'];
                if(isset($item['urlToImage'])){  $image=$item['urlToImage'];  } else {  $image='';}
                if(isset($item['url'])){  $link=$item['url'];  } else {  $link='';}
                if(isset($item['content'])){  $content=$item['content'];  } else {  $content=''; }
                $categoryId='';
                $categoryName='';
                if(isset($item['author'])){  $autherProfie=$item['author'];  } else {  $autherProfie='';}
                if(isset($item['author'])){   $authorName=$item['author']; } else {  $authorName='';}
                $date=$item['publishedAt'];
                if(isset($item['source']['name'])){   $sourceName=$item['source']['name']; } else {  $sourceName='';}
        
           // dd($setArray);
            $newSetArray[]= $this->newArray($id, $title, $sourceName, $image, $content, $link, $categoryId, $categoryName, $autherProfie, $authorName, $date);
         
           
          }
         //   dd($newSetArray);

           return $newSetArray;
          
        }
      //  echo count($newsData['response']);
    

    }
    
    public function guardinReformatArray(){

        $theGuardin = new GuardianApiController();
            //  $newsData= $theGuardin->theGuardianHomeNews();
            // return $this->theGuardianCategorySearch('');
            // return $this->theGuardianNewsSearch('Krishna');
            //  $newsData= $theGuardin->theGuardianCategorySearch('Travel');

        $newsData= $theGuardin->theGuardianNewsSearch('Apple');
        // dd($newsData);
        if(isset($newsData['response']['results'])){
            $resultData = $newsData['response']['results'];
          //  dd($resultData);
          $newSetArray=[];
            foreach($resultData as $item){
              //  dd($item);
                $id=$this->getId();
                $title=$item['webTitle'];
                if(isset($item['fields']['thumbnail'])){  $image=$item['fields']['thumbnail'];  } else {  $image='';}
                if(isset($item['fields']['shortUrl'])){  $link=$item['fields']['shortUrl'];  } else {  $link='';}
                if(isset($item['blocks']['body'][0]['bodyTextSummary'])){  $content=$item['blocks']['body'][0]['bodyTextSummary'];  } else {  $content=''; }
                $categoryId=$item['sectionId'];
                $categoryName=$item['sectionName'];
                if(isset($item['tags'][0]['type'])){  $autherProfie=$item['tags'][0]['type'];  } else {  $autherProfie='';}
                if(isset($item['tags'][0]['webTitle'])){   $authorName=$item['tags'][0]['webTitle']; } else {  $authorName='';}
                $date=$item['webPublicationDate'];
        
           // dd($setArray);
            $newSetArray[]= $this->newArray($id, $title, 'The Guardin', $image, $content, $link, $categoryId, $categoryName, $autherProfie, $authorName, $date);
            }
           // dd($newSetArray);

           return $newSetArray;
        }
      //  echo count($newsData['response']);

    }


    public function newArray($id, $title, $source, $image, $content, $link, $categoryId, $categoryName, $autherProfie, $authorName, $date){
    $dateFormat = date('Y-m-d h:i:s', strtotime($date));
    $dateHuman = date('d M Y', strtotime($date));
        return  [   'id'=>$id,
                    'title'=>$title,
                    'source'=>$source,
                    'image'=>$image,
                    'content'=>$content,
                    'link'=>$link,
                    'categoryId'=>$categoryId,
                    'categoryName'=>$categoryName,
                    'autherProfie'=>$autherProfie,
                    'authorName'=>$authorName,
                    'date'=>$dateFormat,
                    'date_human'=>$dateHuman,
                ];
        
    }


    public function getId(){
        $milliseconds = ceil(microtime(true));
        $intId = filter_var($milliseconds, FILTER_SANITIZE_NUMBER_INT);
       // dd($milliseconds);
        return $intId;
    }

    public function settingsCronJobs(){
      
      $dataNewYork = $this->newYorkTimesReformatArray();
      //  dd($dataNewYork);
        $dataNewsApi = $this->newsApiReformatArray();
        $dataGuardin= $this->guardinReformatArray();

        $dataAll = array_merge($dataNewYork,$dataNewsApi, $dataGuardin);

        $sttingObj = new SettingsController();

        $sttingObj->searchAndSave($dataAll);
    }
    
    
    /*
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

    */
    
}