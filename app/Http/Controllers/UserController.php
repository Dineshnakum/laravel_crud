<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function showUsers()
    {
        $users = DB::table("users")
        ->orderBy("id")
        ->cursorPaginate(4);
        return view('allusers', ['data' => $users]);

        // return $users;
        // foreach ($users as $user){
        //     echo $user->name . "<br>";
        // }
    }

    public function singleUser(string $id)
    {
        $user = DB::table("users")->where('id', $id)->select('email')->get();
        // $a = $user->email;
        return $user;
        // return view('user', ['data' => $user]);
    }

    public function addUser(Request $req)
    {
        $user = DB::table('users')
            ->insertOrIgnore([
                [
                    'name' => $req->username,
                    'email' => $req->useremail,
                    'age' => $req->userage,
                    'city' => $req->usercity
                ]
            ]);

        // dd($user);

        if($user){
            return redirect()->route('home');
        }else{
            return "<h1> data not added</h1>";
        }
    }

    public function updatePage(string $id){
        // $user = DB::table("users")->where('id', $id)->get();
        $user = DB::table("users")->find( $id );
        return view('updateuser', ['data' => $user]);
    }

    public function updateUser(request $req, $id)
    {
        $user = DB::table("users")
            ->where('id', $id)
            ->update([
                'name' => $req->username,
                'email' => $req->useremail,
                'age' => $req->userage,
                'city' => $req->usercity
            ]);

        if ($user) {
            return redirect()->route('home');
        } else {
            echo "<h1> data not updated</h1>";
        }
    }

    public function deleteUser(string $id){
        $user = DB::table("users")
        ->where("id",$id)
        ->delete();

        if($user){
            return redirect()->route('home');
        }else{
            return "<h1> data not deleted</h1>";
        }
    }

}

