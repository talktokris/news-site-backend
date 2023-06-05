<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Users_authors_setting;
use App\Models\Users_category_setting;
use App\Models\Users_source_setting;
use App\Models\News_category;
use App\Models\Author_list;
use App\Models\News_source;

use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserAuthorResource;
use App\Http\Resources\UserCategoryResource;
use App\Http\Resources\UserSourceResource;

use App\Http\Controllers\Api\SettingsController;

class ProfileController extends Controller
{
    public function profile(Request $request){

      //  return "hi";

        $id = auth('sanctum')->user()->id;

      // return $id;
  
       return $user_info = User::where('id',$id)->get();

          return response()->json([
              'status' => 'success',
              'results' => UserProfileResource::collection($user_info)
            
          ]);
    }

    public function saveUserSetting(Request $request){

        $id = auth('sanctum')->user()->id;
       // return $id;
        $type= $request['settingName'];
        $fill_id= $request['stringId'];

        if($type==='source'){

       
              $newSourceData = News_source::where('id', $fill_id)->get()->toArray(); 
              if(count($newSourceData)>=1){
                $newSourceDataCount = Users_source_setting::where('user_id', $id)->where('name', $newSourceData[0]['name'])->get()->count(); 
                
                if($newSourceDataCount>=1){
                  return $this->jsonReturn('error', 'This source setting is already exist');
                } else {
               // return $newSourceData[0]['name'];
                  $SaveData = new Users_source_setting;
                  $SaveData->user_id=$id;
                  $SaveData->name = $newSourceData[0]['name'];
                  $SaveData->label =$newSourceData[0]['label'];
                  $SaveData->status = 1;
                  $SaveData->save();
                    if($SaveData){
                      return $this->jsonReturn('success', 'Source setting saved successfully');
                    } else { return $this->jsonReturn('error', 'Known error');}
                    
                  }

              }
          } elseif($type==='category'){

          $newSourceData = News_category::where('id', $fill_id)->get()->toArray(); 
     
              if(count($newSourceData)>=1){

                $newSourceDataCount = Users_category_setting::where('user_id', $id)->where('name',$newSourceData[0]['name'])->get()->count(); 
                  if($newSourceDataCount>=1){
                    return $this->jsonReturn('error', 'This category setting is already exist');
                  } else {
                    $SaveData = new Users_category_setting;
                    $SaveData->user_id=$id;
                    $SaveData->name = $newSourceData[0]['name'];
                    $SaveData->label =$newSourceData[0]['label'];
                    $SaveData->status = 1;
                    $SaveData->save();
                    if($SaveData){
                      return $this->jsonReturn('success', 'Category setting saved successfully');
                    } else { return $this->jsonReturn('error', 'Known error');}
                 
                  }

            }
          
        } 
        elseif($type==='author'){

          $newSourceData = Author_list::where('id', $fill_id)->get()->toArray(); 
    
              if(count($newSourceData)>=1){

                $newSourceDataCount = Users_authors_setting::where('user_id', $id)->where('name', $newSourceData[0]['name'])->get()->count(); 
                  if($newSourceDataCount>=1){
                    return $this->jsonReturn('error', 'This auther setting is already exist');
                  } else {
                    $SaveData = new Users_authors_setting;
                    $SaveData->user_id=$id;
                    $SaveData->name = $newSourceData[0]['name'];
                    $SaveData->label =$newSourceData[0]['label'];
                    $SaveData->status = 1;
                    $SaveData->save();
                    if($SaveData){
                      return $this->jsonReturn('success', 'Auther setting saved successfully');
                    } else { return $this->jsonReturn('error', 'Known error');}
                   
                  }

              }
          

        }

  
       
    }


    public function deleteUserSetting(Request $request){

      $id = auth('sanctum')->user()->id;
     // return $id;
      $type= $request['settingName'];
      $fill_id= $request['stringId'];

      if($type==='source'){
          $SaveData = Users_source_setting::where('id','=', $fill_id)->where('user_id','=', $id)->delete();;
        if($SaveData){
           return $this->jsonReturn('success', 'Source setting deleted successfully');
          }else { return $this->jsonReturn('error', 'Known error');}
         
      } elseif($type==='category'){
          $SaveData = Users_category_setting::where('id','=', $fill_id)->where('user_id','=', $id)->delete();;
          if($SaveData){
          return $this->jsonReturn('success', 'Category setting deleted successfully');
          }else { return $this->jsonReturn('error', 'Known error');}
      } 
      elseif($type==='author'){
       
          $SaveData = Users_authors_setting::where('id','=', $fill_id)->where('user_id','=', $id)->delete();;
          if($SaveData){
             return $this->jsonReturn('success', 'Author setting deleted successfully');
        } else { return $this->jsonReturn('error', 'Known error');}

      }


  }

    public function jsonReturn($status, $message){
      return response()->json([
        'status' => $status,
        'message' => $message,
    ]);
    }


    public function userSettings(Request $request){

      $newsSetting  = new SettingsController();
      $filterSettings =$newsSetting->getNewsSeettings();

        $id = auth('sanctum')->user()->id;

        $souresData = Users_source_setting::where('user_id',$id)->get();
        $categoriesData = Users_category_setting::where('user_id',$id)->get();
        $authoresData = Users_authors_setting::where('user_id',$id)->get();



     //  return $user_info = User::where('id',$id)->get();

          return response()->json([
              'status' => 'success',
              'fill_settings' =>  $filterSettings,
              'user_sources' => UserSourceResource::collection($souresData),
              'user_categories' =>  UserCategoryResource::collection($categoriesData),
              'user_authors' =>  UserAuthorResource::collection($authoresData),
             // 'results' => UserProfileResource::collection($user_info);
            
          ]);
    }
      
}