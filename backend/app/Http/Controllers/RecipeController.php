<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    /*
    get all recipes and filter by category
    */
    public function index()
    {
        try {

            // throw new \Exception('this is error');
            return Recipe::filter(request(['category']))->with('category')->orderBy('created_at', 'desc')->paginate(6);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);

        }
    }

    /*
    * store a recipe
    * POST - /api/recipes
    * @param title, description, category_id, photo (uploaded URL - need to call upload api first)
    */
    public function store() 
    {
        try {

            // validation 
            $validator = Validator::make(request()->all(), [
                'title' => 'required',
                'description' => 'required',
                'category_id' => ['required', Rule::exists('categories', 'id')],
                'photo' => 'required',
            ]);

            if ($validator->fails()) {
                $flatteredErrors = collect($validator->errors())->flatMap(function ($error, $field) {
                    return [ $field => $error[0]];
                });


                return response()->json([
                    'errors' => $flatteredErrors,
                    'status' => 400
                ], 400);
            }

            // validation passed 
            $recipe = new Recipe();
            $recipe->title = request('title');
            $recipe->description = request('description');
            $recipe->photo = request('photo');
            $recipe->category_id = request('category_id');
            $recipe->save();

            return response()->json($recipe, 201);
            
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);

        }
    }

    /*
    * update a recipe
    * PATCH - /api/recipes/{recipe}
    * @param title, description, category_id, photo (uploaded URL - need to call upload api first)
    */
    public function update($id) 
    {
        try {

            $recipe = Recipe::find($id);
            if (!$recipe) {
                return response()->json([
                    'message'   => 'recipe not found',
                    'status'    => 404
                ], 404);
            }

            // validation 
            $validator = Validator::make(request()->all(), [
                'title' => 'required',
                'description' => 'required',
                'category_id' => ['required', Rule::exists('categories', 'id')],
                'photo' => 'required',
            ]);

            if ($validator->fails()) {
                $flatteredErrors = collect($validator->errors())->flatMap(function ($error, $field) {
                    return [ $field => $error[0]];
                });


                return response()->json([
                    'errors' => $flatteredErrors,
                    'status' => 400
                ], 400);
            }

            // validation passed 
            $recipe->title = request('title');
            $recipe->description = request('description');
            $recipe->photo = request('photo');
            $recipe->category_id = request('category_id');
            $recipe->save();

            return response()->json($recipe, 201);
            
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);

        }
    }

    /*
    get single recipe
    */
    public function show($id)
    {
        try {

            $recipe = Recipe::find($id);
            if (!$recipe) {
                return response()->json([
                    'message'   => 'recipe not found',
                    'status'    => 404
                ], 404);
            }

            return $recipe;

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);

        }
    }

    public function destroy($id)
    {
        try {

            $recipe = Recipe::find($id);
            if (!$recipe) {
                return response()->json([
                    'message'   => 'recipe not found',
                    'status'    => 404
                ], 404);
            }

            $recipe->delete();
            
            return $recipe;

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);

        }
    }

    /*
    * upload a photo
    * POST - /api/recipes/upload
    * @param photo
    */
    public function upload()
    {
        try {

            // validation 
            $validator = Validator::make(request()->all(), [
                'photo' => ['required', 'image'],
            ]);

            if ($validator->fails()) {
                $flatteredErrors = collect($validator->errors())->flatMap(function ($error, $field) {
                    return [ $field => $error[0]];
                });


                return response()->json([
                    'errors' => $flatteredErrors,
                    'status' => 400
                ], 400);
            }

            $path = env('APP_URL') . '/storage/' . request('photo')->store('/recipes');

            return [
                'path' => $path,
                'status' => 200,
            ];

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);

        }
    }
}
