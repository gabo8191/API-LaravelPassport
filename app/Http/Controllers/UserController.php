<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $allUsers = User::all();
        return response()->json([
            'message' => 'This is the index method from the UserController',
            'users' => $allUsers
        ], 200);
    }
    public function show($id)
    {
        $user = User::find($id);
        return response()->json([
            'message' => 'This is the show method from the UserController',
            'user' => $user
        ], 200);
    }

    

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);
        $user = User::where('id', $id)->update($request->all());
        return response()->json([
            'message' => 'This is the update method from the UserController',
            'user' => $user
        ], 200);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json([
            'message' => 'This is the destroy method from the UserController',
        ], 200);
    }

    public function oauth_clients(){
        $oauth_clients = DB::table('oauth_clients')->get();
        return response()->json([
            'message' => 'This is the oauth_clients method from the UserController',
            'oauth_clients' => $oauth_clients
        ], 200);
    }
}
