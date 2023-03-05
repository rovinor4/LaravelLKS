<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $valid = MainController::requestValid($request,["id" => "required"],["id"]);
            
            if(!$valid["status"]){
                return response()->json([
                    "status" => false,
                    "message" => $valid["message"]
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
    
            $get = null;
            if($request->search){
                $search = $request->search;
                $get = News::where("user_id",$request->id)
                            ->orWhere('judul', 'like', '%' . $search . '%')
                            ->orWhere('slug', 'like', '%' . $search . '%')
                            ->orWhere('isi', 'like', '%' . $search . '%');
            }else{
                $get = News::where("user_id",$request->id);
            }
    
            if($get->count() > 0){
                return response()->json([
                    'status' => false,
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
    public function show(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}
