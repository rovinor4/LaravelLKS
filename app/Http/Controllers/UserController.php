<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {       
        $userRole = User::$rules;
        $valid = MainController::requestValid($request,$userRole,["email","password"]);

        if(!$valid["status"]){
            return response()->json([
                "status" => false,
                "message" => $valid["message"]
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (Auth::attempt($valid["message"])) {
            return response()->json([
                "status" => true,
                "data" => Auth()->user()
            ]);
        }
        
        return response()->json([
            "status" => false,
            "message" => "Login wrong make sure the username and password are correct"
        ],Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userRole = User::$rules;
        $userRole["email"] .= "|unique:users";
        $userRole["name"] .= "|required";
        $valid = MainController::requestValid($request,$userRole,["name","email","password"]);

        if(!$valid["status"]){
            return response()->json([
                "status" => false,
                "message" => $valid["message"]
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            $uuid = Str::uuid();
            $date = Carbon::now();
            $date = $date->utc();
            $token = hash('sha256', $date."_".$uuid);
            $valid["message"]["remember_token"] = $token;
            $valid["message"]["password"] = Hash::make($valid["message"]["password"]);
            
            if(!User::count()){
                $valid["message"]["is_admin"] = true;
            }
            
            $userCreate = User::create($valid["message"]);

            return response()->json([
                "status" => true,
                "data" => $userCreate
            ]);

        } catch (\Exception  $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $valid = MainController::requestValid($request,["name" => "required|max:255"],["name"]);
            
            if(!$valid["status"]){
                return response()->json([
                    "status" => false,
                    "message" => $valid["message"]
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $data = $user->update($valid["message"]);
            return response()->json([
                "status" => true,
                "update" => $data
            ]);

        } catch (\Exception  $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $data = $user->delete();
            return response()->json([
                "status" => true,
                "delete" => $data
            ]);

        } catch (\Exception  $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
