<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News_category;
use App\Models\Author_list;
use App\Models\News_source;

use App\Http\Resources\NewsCategoryResource;
use App\Http\Resources\NewsSourceResource;
use App\Http\Resources\NewsAuthorResource;


class SettingsController extends Controller
{

    public function getNewsSeettings(){

       //dd("hi");

       $newSourceData = News_source::where('status', 1)->get(); 
      // dd($newSourceData);
       $newCategoryData = News_category::where('status', 1)->get(); 
       $newAuthorData = Author_list::where('status', 1)->get(); 
       return [
            'status' => 'success',
            'categories' => NewsCategoryResource::collection($newCategoryData),
            'sources' => NewsSourceResource::collection($newSourceData),
            'authors' => NewsAuthorResource::collection($newAuthorData),
   
        ];


       
    }

    public function searchAndSave($data){

      //  $arraySource =array_column($data, 'source', 'categoryName');
       // dd($arraySource);

        $sourceRecords = $this->filterColumnArray($data, 'source');
        $this->saveSources($sourceRecords);

        $categoryRecords = $this->filterColumnArrayWithKey($data, 'source', 'categoryName');
        $this->saveCategory($categoryRecords);

        $authorRecords = $this->filterColumnArrayWithKey($data,'source', 'authorName');
        $this->saveAuthor($authorRecords);

   
    }


    public function saveAuthor($data=[]){


        foreach($data as $key => $item){

            $newsSourceId=$this->getNewsSourceID($item);
           // dd($newsSourceId);
            $find = Author_list::where('label','=', $item)->where('news_source_id','=', $newsSourceId)->get()->count();
            if(($find==0)&&($key!="")){
                $SaveData = new Author_list;
                $SaveData->news_source_id=$newsSourceId;
                $SaveData->name = $key;
                $SaveData->label = ucfirst($key);
                $SaveData->status = 1;
                $SaveData->save();
            }
        }

    }

    public function saveCategory($data=[]){


        foreach($data as $key => $item){

            $newsSourceId=$this->getNewsSourceID($item);
           // dd($newsSourceId);
            $find = News_category::where('label','=', $item)->where('news_source_id','=', $newsSourceId)->get()->count();
            if(($find==0)&&($key!="")){
                $SaveData = new News_category;
                $SaveData->news_source_id=$newsSourceId;
                $SaveData->name = $key;
                $SaveData->label = ucfirst($key);
                $SaveData->status = 1;
                $SaveData->save();
            }
        }


    }




    public function saveSources($data=[]){

        foreach($data as $item){
          
            $find = News_source::where('label', $item)->get()->count();
           // dd($find);
            if(($find==0)&&($item!="")){
                $SaveData = new News_source;
                $SaveData->name = $item;
                $SaveData->label = ucfirst($item);
                $SaveData->status = 1;
                $SaveData->save();
            }
        }
    }


    public function filterColumnArrayWithKey ($data, $keyName, $columnName){
        $arraySource =array_column($data, $keyName, $columnName);
      //  dd($arraySource);
       // $findUnique = array_unique($arraySource);
        return $arraySource;
    }
    public function filterColumnArray ($data, $columnName){
        $arraySource =array_column($data, $columnName);
        $findUnique = array_unique($arraySource);
        return $findUnique;
    }

    public function getNewsSourceID($name){
        $SouceData = News_source::where('name', $name)->get();
        foreach ($SouceData as $data){
            $id= $data->id;
        }
        if($id==""){ return 0; }
        return $id;
    }
  
}