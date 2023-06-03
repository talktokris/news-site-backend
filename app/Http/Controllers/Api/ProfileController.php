<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserProfileResource;

class ProfileController extends Controller
{
    public function profile(Request $request){

      //  return "hi";

        $id = auth('sanctum')->user()->id;
  
        $user_info = User::where('id',$id)->get();

          return response()->json([
              'status' => 'success',
              'results' => UserProfileResource::collection($user_info)
            
          ]);
       }
      
}