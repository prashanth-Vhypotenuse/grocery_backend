<?php

namespace App\Http\Controllers;

use App\Models\Grocery;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GroceryController extends Controller{


    // public function create(Request $request){


    //     $grocery=Grocery::join('categories','categories.id','=','groceries.category_id')
    //     ->select("categories.*")
    //     ->where("categories.id", $request->category_id)
    //     ->exists();
    //     Log::error("AA", [$grocery]);
    //     if($grocery){
    //         return response()->json([
    //             "message" => "Grocery successfully created"
    //         ], 200);
    //     }
    //     else {
    //         return response()->json([
    //             "message" => "Invalid category Id"
    //         ], 400);
    //     }
    //     $validation = Validator::make($request->all(), [
    //         "category_id" => "required",
    //         "groceryName" => "required",
    //         "groceryQuantity" => "required",
    //     ]);

    //     if ($validation->fails()) {
    //         return response()->json([
    //             "message" => "Validation error",
    //             "error" => $validation->errors()
    //         ], 400);
    //     }
        
    //     try {
           
            
    //         if($categoryId) {
    //             $categoryId = Grocery::insert([
    //                 "groceryName" => $request->groceryName,
    //                 "category_id" => $request->category_id,
    //                 "groceryQuantity" => $request->groceryQuantity,
    //                 "created_at" => Carbon::now()->format("Y-m-d H:i:s")
    //             ]);
            
    //     } catch (Exception $e) {
    //         Log::error("Grocery_create", [$e]);
    //         return response()->json([
    //             "message" => "Internal server error",
    //         ], 500);
    //     }
    // }
    public function create(Request $request)
        {
            $grocery = Grocery::select("*")
            ->where("category_id", $request->category_id)
            ->where("groceryName", $request->groceryName)
            ->exists();
            Log::error("category",[$grocery]);

            if ($grocery) {
                return response()->json([
                    "message" => "Grocery already exist"
                ], 400);
            } else{
                $validation = Validator::make($request->all(),[
                    "category_id"=>"required|numeric",
                    "groceryName" => "required|string|max:150",
                    "groceryQuantity"=>"required|integer|max:100"
                ]);
            if($validation->fails()){
                return response()->json([
                    "message" => "validation error",
                    "result" => $validation->errors()
                ], 400);
            }
            try{
                $grocery=Category::select("categories.id")
                ->where("categories.id", $request->category_id)
                ->exists();

                Log::error("insert",[$grocery]);
                if ($grocery) {
                    $grocery=Grocery::insert([
                        "category_id"=>$request->category_id,
                        "groceryName" => $request->groceryName,
                        "groceryQuantity"=>$request->groceryQuantity,
                        "created_at" => carbon::now()->format("Y-m-d H:i:s"),
                ]);
                if($grocery){
                    return response()->json([
                        "message" => "Grocery successfully "
                    ], 200);
                    }
                else {
                    return response()->json([
                        "message" => "Grocery create failed"
                    ], 400);
                }
                }     
                else{
                    return response()->json([
                        "message" => "Invalid category"
                    ], 400);
                }
            }
        catch(Exception $e){
            Log::error("Grocery_insert_error",[$e]);
            return response()->json([
                "message" => "Internal server error"
            ], 500);
        }
    }}

    public function getGroceryById($groceryId){
        try{ 
            $grocery = Grocery::where("id", $groceryId)->get();  

            if ($grocery) {
                return response()->json([
                    "message" => "Success",
                    "result" => $grocery,
                ], 200);
            } else {
                return response()->json([
                    "message" => "No records found"
                ], 404);
            }
        }catch (Exception $e) {
            Log::error("getGrocery_error", [$e]);
            return response()->json([
                "message" => "Internal server error"
            ], 500);
        }
    }

    public function getAllGrocery() {

        try{
            $grocery = Grocery::join("categories", "categories.id", "=", "groceries.category_id")
            ->select('groceries.*', 'categories.name')
            ->get();
            if($grocery) {
                return response()->json([
                    "message" => "Success",
                    "result" => $grocery
                ], 200);
            } else {
                return response()->json([
                    "message" => "not found",
                ], 404);
            }
        }catch(Exception $e){
            Log::error('getgrocery_error', [$e]);
            return response()->json([
                "message" => "Internal server Error",
            ], 500);
        }
    }

    public function updateGrocery(Request $request, $groceryId){
        // $grocery = Grocery::select("*")
        // ->where("category_id", $request->category_id)
        // ->where("groceryName", $request->groceryName)
        // ->exists();
        // Log::error("category",[$grocery]);

        // if ($grocery) {
        //     return response()->json([
        //         "message" => "Grocery already exist"
        //     ], 400);
        // } else{
        //     $validation = Validator::make($request->all(),[
        //         "category_id"=>"required|numeric",
        //         "groceryName" => "required|string|max:150",
        //         "groceryQuantity"=>"required|integer|max:100"
        //     ]);
        // if($validation->fails()){
        //     return response()->json([
        //         "message" => "validation error",
        //         "result" => $validation->errors()
        //     ], 400);
        // }
        $validation = Validator::make($request->all(), [
            "category_id"=>"required|numeric",
            "groceryName" => "required|string|max:150",
            "groceryQuantity"=>"required|integer|max:100"
        ]);

        if ($validation->fails()) {
            return response()->json([
                "message" => "Validation error",
                "error" => $validation->errors()
            ], 400);
        }
        try {
            $grocery = Grocery::where( "id", $groceryId)->update([
                "groceryName" => $request->groceryName,
                "category_id" => $request->category_id,
                "groceryQuantity" => $request->groceryQuantity,
                "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
            ]);
            if($grocery){
            return response()->json([
                "message" => "Grocery Updated successfully",
            ], 200);
        }else{
            return response()->json([
                "message" => "Grocery update error",
            ], 400);
            }
        } catch (Exception $e) {
            Log::error("Grocery_update", [$e]);
            return response()->json([
                "message" => "Internal server error",
            ], 500);
        }
    }

    public function deleteGrocery($groceryId){
        if(!$groceryId) {
            return response()->json([
                "message" => "Bad request",
            ], 400);
        }

        try {
            $grocery = Grocery::where("id", $groceryId)->delete();
            if($grocery) {
                return response()->json([
                    "message" => "Grocery deleted successfully",
                ], 200);
            } else {
                return response()->json([
                    "message" => "Grocery cannot delete",
                ], 400);
            }
        } catch (Exception $e) {
            Log::error("Grocery_delete", [$e]);
            return response()->json([
                "message" => "Internal server error",
            ], 500);
        }
    }
}