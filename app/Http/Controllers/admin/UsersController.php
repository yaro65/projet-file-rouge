<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Session;

class UsersController extends Controller
{
    public function Users()
    {
        Session::put('page','users');
        $users = User::get()->toArray();
        return view('admin.users.users')->with(compact('users'));
    }

    public function updateUserStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
        }if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        User::where('id',$data['user_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'suser_id'=>$data['user_id']]);
    }
}
