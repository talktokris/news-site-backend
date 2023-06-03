<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthBaseController; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;


class AuthApiController extends AuthBaseController
{

    
    public function userLogin(Request $request)
    {

 
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role'=>1])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('frontEndApp')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
        
    }


    

    public function userRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role'] = 1;
        $user = User::create($input);
        $success['token'] =  $user->createToken('frontEndApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
}