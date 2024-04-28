<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;

// get all categories
Route::get('/categories', [CategoryController::class, 'index']);

// get all recipes
Route::get('/recipes', [RecipeController::class, 'index']);

// store a recipe
Route::post('/recipes', [RecipeController::class, 'store']);

// update a single recipe 
Route::patch('/recipes/{recipe}', [RecipeController::class, 'update']);

// get single recipe 
Route::get('/recipes/{recipe}', [RecipeController::class, 'show']);

// delete single recipe 
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy']);

// upload api
Route::post('/recipes/upload', [RecipeController::class, 'upload']);