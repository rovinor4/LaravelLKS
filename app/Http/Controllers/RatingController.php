<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(News $news)
    {
        try{
            $get = Rating::where("news_id",$news->id)->get();
            if($get->count() > 0){
                return response()->json([
                    'status' => true,
                    'data' => $get 
                ], 200);   
            }else{
                return response()->json([
                    'status' => false,
                    'message' => "No data found"
                ], Response::HTTP_INTERNAL_SERVER_ERROR);   
            }
        }catch (\Exception  $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $ratingLog = Rating::$rules;
            $valid = $request->validate($ratingLog);
            $ratingCreate = Rating::updateOrCreate(["user_id" => $valid["user_id"],"news_id" => $valid["news_id"]],$valid);

            if($ratingCreate){
                return response()->json([
                    "status" => true,
                    "data" => $ratingCreate
                ]);
            }
        }catch(\Exception  $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating,Request $request)
    {
        try{
            $id = $request->user_id;
            $data = $rating->where("user_id",$id)->get();
            if($data){
                return response()->json([
                    "status" => true,
                    "data" => $data
                ]);
            }
        }catch(\Exception  $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rating $rating)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        try{
            $x = $rating->delete();
            return response()->json([
                'status' => true,
                'message' => $x
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }catch(\Exception  $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
