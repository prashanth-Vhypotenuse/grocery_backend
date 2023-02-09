<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Category;

class CategoryController extends Controller {
    // public function getCategoryById($groceryId)
    // {
    //     try{ 
    //         $grocery = Category::find( "id", $groceryId)->get("name");  

    //         if (count($grocery) > 0) {
    //             return response()->json([
    //                 "message" => "Success",
    //                 "result" => $grocery,
    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 "message" => "No records found"
    //             ], 404);
    //         }
    //     }catch (Exception $e) {
    //             Log::error("getCategoryType_error", [$e]);
    //             return response()->json([
    //                 "message" => "Internal server error",
    //             ], 500);
    //         }
        
    // }

    public function getAllCategory() {
        try{
            $category = Category::get();
            if($category) {
                return response()->json([
                    "message" => "Success",
                    "result" => $category
                ], 200);
            } else {
                return response()->json([
                    "message" => "not found",
                ], 404);
            }
        }catch(Exception $e){
            Log::error('getCategoryById_error', [$e]);
            return response()->json([
                "message" => "Internal server Error",
            ], 500);
        }
    }
}
