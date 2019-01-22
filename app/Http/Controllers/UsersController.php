<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User; 

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function CreateUser(Request $request)
    {
        $data = $request->json()->all();
        $dataUser= $data['user'];
        $user = User::create([
            'name' => strtoupper($dataUser['name']),
            'user_name' => $dataUser['user_name'],
            'email' => $dataUser['email'],
            'password' => $dataUser['password'],
            
            ]);
           
    }

    //
}