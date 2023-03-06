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
            // $valid = MainController::requestValid($request,["id" => "required"],["id"]);
            // if(!$valid["status"]){
            //     return response()->json([
            //         "status" => false,
            //         "message" => $valid["message"]
            //     ],Response::HTTP_INTERNAL_SERVER_ERROR);
            // }
    


            $get = null;
            if($request->search){
                $search = $request->search;
                $get = News::where('judul', 'like', '%' . $search . '%')
                            ->orWhere('slug', 'like', '%' . $search . '%')
                            ->orWhere('isi', 'like', '%' . $search . '%')->paginate(6);
            }else{
                $get = News::paginate(6);
            }
    
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
            $newsLog = News::$rules;
            $valid = $request->validate($newsLog);

            $NewsCreate = News::upsert($valid,["user_id","slug"]);

            if($NewsCreate){
                return response()->json([
                    "status" => true,
                    "data" => $NewsCreate
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
    public function show(News $news)
    {
        try{
            if($news){
                return response()->json([
                    "status" => true,
                    "data" => $news
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
    public function update(News $news,Request $request)
    {
        // try{
        //     $newsLog = News::$rules;
        //     $valid = MainController::requestValid($request,$newsLog,["user_id","judul","slug","isi"]);
        //     if(!$valid["status"]){
        //         return response()->json([
        //             "status" => false,
        //             "message" => $valid["message"]
        //         ],Response::HTTP_INTERNAL_SERVER_ERROR);
        //     }
            
        //     $NewsCreate = $news->update($valid["message"]);

        //     if($NewsCreate){
        //         return response()->json([
        //             "status" => true,
        //             "update" => $NewsCreate
        //         ]);
        //     }
        // }catch(\Exception  $e) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => $e->getMessage()
        //     ], Response::HTTP_INTERNAL_SERVER_ERROR);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        try{
            $NewsCreate = $news->delete();
            if($NewsCreate){
                return response()->json([
                    "status" => true,
                    "delete" => $NewsCreate
                ]);
            }
        }catch(\Exception  $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
