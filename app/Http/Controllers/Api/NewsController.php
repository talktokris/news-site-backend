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

 

     return $data = $this->search('Apple');
     // dd($data);
/*
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
       */
    }


    public function search($string=""){

     // dd("hi");
    
    //  dd($string);
      //Filter Setting Data Fatching for API
      $newsSetting  = new SettingsController();
      $filterSettings =$newsSetting->getNewsSeettings();
/*
      //Latest News Data Fatching for New York API
      $newYorkObj = new NewYorkApiController();
      $newsDataOne= $newYorkObj->newYorkTimesNewsSearch($string);
       // dd($newsDataOne);
      $dataNewYork = $this->newYorkTimesReformatArraySearch($newsDataOne);
    */

      //Latest News Data Fatching for New API
      $newsApiObj = new NewsApiController();
      $newsDataTwo= $newsApiObj->newApiNewsSearch($string);
     
      $dataNewsApi = $this->newsApiReformatArray($newsDataTwo);
     
      //Latest News Data Fatching for Guardin API
      $theGuardin = new GuardianApiController();
      $newsDataThree= $theGuardin->theGuardianNewsSearch($string);
     // dd($newsDataThree);
      $dataGuardin= $this->guardinReformatArray($newsDataThree);
     // dd($dataGuardin);
     // $dataAllPre = array_merge($dataNewYork,$dataNewsApi, $dataGuardin);

     if(is_array($dataNewYork)){} else{ $dataNewYork=[];}
     if(is_array($dataNewsApi)){} else{ $dataNewsApi=[];}
     if(is_array($dataGuardin)){} else{ $dataGuardin=[];}
     $dataAllPre = array_merge($dataNewYork,$dataNewsApi, $dataGuardin);
     
     // $dataAll = array_merge($dataNewsApi, $dataGuardin);
      
     // shuffle($dataNewsApi);
     // shuffle($dataAll);
    // $dataAll = array_slice($dataAllPre, 0, 50);

    // dd($dataAll);

      //available News Date Filter Setup
     $setDatesArray = $this->getDateArray($dataAll);

      return response()->json([
        'status' => 'success',
        'filterSettings' => $filterSettings,
        'filterDates'=>$setDatesArray,
        'newsData' => $dataAll,
        //'authors' => NewsAuthorResource::collection($newAuthorData),
   
    ]);
   }

    public function homePage(){
       //Filter Setting Data Fatching for API
       $newsSetting  = new SettingsController();
       $filterSettings =$newsSetting->getNewsSeettings();

      //Latest News Data Fatching for New York API
      $newYorkObj = new NewYorkApiController();
      $newsDataOne= $newYorkObj->newYorkTimesHomeNews();
      //  dd($newsData);
      $dataNewYork = $this->newYorkTimesReformatArray($newsDataOne);
   

       //Latest News Data Fatching for New API
       $newsApiObj = new NewsApiController();
       $newsDataTwo= $newsApiObj->newApiNewsHome();
       $dataNewsApi = $this->newsApiReformatArray($newsDataTwo);
      // dd($dataNewsApi);

       //Latest News Data Fatching for Guardin API
       $theGuardin = new GuardianApiController();
       $newsDataThree= $theGuardin->theGuardianHomeNews();
       $dataGuardin= $this->guardinReformatArray($newsDataThree);
       if(is_array($dataNewYork)){} else{ $dataNewYork=[];}
       if(is_array($dataNewsApi)){} else{ $dataNewsApi=[];}
       if(is_array($dataGuardin)){} else{ $dataGuardin=[];}
       $dataAll = array_merge($dataNewYork,$dataNewsApi, $dataGuardin);
       shuffle($dataAll);

       //available News Date Filter Setup
      $setDatesArray = $this->getDateArray($dataAll);

       return response()->json([
         'status' => 'success',
         'filterSettings' => $filterSettings,
         'filterDates'=>$setDatesArray,
         'newsData' => $dataAll,
         //'authors' => NewsAuthorResource::collection($newAuthorData),
    
     ]);
    }

    public function getDateArray($dataAll){

      $dates = array_column($dataAll,'date_human');
      $uiniqueDates = array_unique($dates);
      sort($uiniqueDates);
      $setDatesArray=[];
      foreach($uiniqueDates as $key=>$value){
       $setDatesArray[]= ['id'=>$key,'name'=>$value, 'label'=>$value];

      }
      return $setDatesArray;

    }

    public function newYorkTimesReformatArraySearch($newsData){

     //  dd($newsData['response']['docs']);

      //  dd($newsApi->newsApiName);
            //  $newsData= $theGuardin->theGuardianHomeNews();
            // return $this->theGuardianCategorySearch('');
            // return $this->theGuardianNewsSearch('Krishna');
            //  $newsData= $theGuardin->theGuardianCategorySearch('Travel');

       // $newYorkObj = new NewYorkApiController();
      //  $newsData= $newYorkObj->newYorkTimesHomeNews();
        // dd($newsData);
         
        if(isset($newsData['response']['docs'])){
     
            $resultData = $newsData['response']['docs'];
           // dd($resultData);
        
          $newSetArray=[];
            foreach($resultData as $item){
               // dd($item);
                $id=$item['uri'];
                $title=$item['abstract'];
                if(isset($item['multimedia'][0]['url'])){  $image=$item['multimedia'][0]['url'];  } else {  $image='';}
                if(isset($item['web_url'])){  $link=$item['web_url'];  } else {  $link='';}
                if(isset($item['lead_paragraph'])){  $content=$item['lead_paragraph'];  } else {  $content=''; }
                if(isset($item['section_name'])){  $categoryId=$item['section_name'];  } else {  $categoryId=''; }
                if(isset($item['type_of_material'])){  $categoryName=$item['section_name'];  } else {  $categoryName=''; }
                if(isset($item['byline'])){  $autherProfie=$item['byline'];  } else {  $autherProfie='';}
                if(isset($item['byline'])){   $authorName=$item['byline']; } else {  $authorName='';}
                $date=$item['pub_date'];
               // if(isset($item['source'])){   $sourceName=$item['source']['name']; } else {  $sourceName='New York Times';}
                $sourceName=$item['source'];
           // dd($setArray);
            $newSetArray[]= $this->newArray($id, $title, $sourceName, $image, $content, $link, $categoryId, $categoryName, $autherProfie, $authorName, $date);
         
           
          }
         //  dd($newSetArray);

           return $newSetArray;
          
        }
      //  echo count($newsData['response']);
    

    }

    public function newYorkTimesReformatArray($newsData){

       

      //  dd($newsApi->newsApiName);
            //  $newsData= $theGuardin->theGuardianHomeNews();
            // return $this->theGuardianCategorySearch('');
            // return $this->theGuardianNewsSearch('Krishna');
            //  $newsData= $theGuardin->theGuardianCategorySearch('Travel');

       // $newYorkObj = new NewYorkApiController();
      //  $newsData= $newYorkObj->newYorkTimesHomeNews();
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
                $sourceName='The New York Times';
           // dd($setArray);
            $newSetArray[]= $this->newArray($id, $title, $sourceName, $image, $content, $link, $categoryId, $categoryName, $autherProfie, $authorName, $date);
         
           
          }
          //  dd($newSetArray);

           return $newSetArray;
          
        }
      //  echo count($newsData['response']);
    

    }

    public function newsApiReformatArray($newsData){

       // $newsApiObj = new NewsApiController();

      //  dd($newsApi->newsApiName);
            //  $newsData= $theGuardin->theGuardianHomeNews();
            // return $this->theGuardianCategorySearch('');
            // return $this->theGuardianNewsSearch('Krishna');
            //  $newsData= $theGuardin->theGuardianCategorySearch('Travel');
   
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
    
    public function guardinReformatArray($newsData){

       // $theGuardin = new GuardianApiController();
            //  $newsData= $theGuardin->theGuardianHomeNews();
            // return $this->theGuardianCategorySearch('');
            // return $this->theGuardianNewsSearch('Krishna');
            //  $newsData= $theGuardin->theGuardianCategorySearch('Travel');
        $theGuardin = new GuardianApiController();
        $newsData= $theGuardin->theGuardianHomeNews();
       // $newsData= $theGuardin->theGuardianNewsSearch('Apple');
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
      
      //Latest News Data Fatching for New York API
      $newYorkObj = new NewYorkApiController();
      $newsData= $newYorkObj->newYorkTimesHomeNews();
      //  dd($newsData);
      $dataNewYork = $this->newYorkTimesReformatArray($newsData);

       //Latest News Data Fatching for New API
       $newsApiObj = new NewsApiController();
       $newsData= $newsApiObj->newApiNewsHome();
       $dataNewsApi = $this->newsApiReformatArray($newsData);

       //Latest News Data Fatching for Guardin API
       $theGuardin = new GuardianApiController();
       $newsData= $theGuardin->theGuardianHomeNews();
       $dataGuardin= $this->guardinReformatArray($newsData);

       if($dataNewYork==null){ $dataNewYork=[];}
       if($dataNewsApi==null){ $dataNewsApi=[];}
       if($dataGuardin==null){ $dataGuardin=[];}

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