<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\User_source_setting;
use App\Models\User_category_setting;
use App\Models\User_authors_setting;
use Illuminate\Http\Request;

class UsersController extends Controller
{
   public function fetchUsers(){
    $userData =User::with('source')->with('author')->with('category')->get();

   // dd($userData);
   // return view("apiPage")->with(compact('apiData'));
    
  // return view("usersPage")->with(compact('source', 'teams', 'selections'));
   return view("usersPage")->with(compact('userData'));
 
}

   public function viewUser($id=null){

     
      $userData =User::where('id', $id)->with('source')->with('author')->with('category')->get();

      // dd($userData);
      // return view("apiPage")->with(compact('apiData'));
       
     // return view("usersPage")->with(compact('source', 'teams', 'selections'));
      return view("usersPageView")->with(compact('userData'));
    //  return view("admin.adminDashboard")->with(compact('fixtures', 'teams', 'selections'));
     }

     public function redirectLogin(){
      return redirect('/login');
     }
}