<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        try {
            $article = Article::all();
            return response()->json($article, Response::HTTP_OK);
        } catch (QueryException $e) {
            $error = ['error' => $e->getMessage()];
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            Article::create($request->all());
            $response = ['Success' => 'New article is created'];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            $error = ['error' => $e->getMessage()];
            return response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function show($id)
    {
        try {
            $article = Article::findOrFail($id);
            $response = [$article];
            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No results found'], Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $article = Article::findOrFail($id);
            $validator = Validator::make($request->all(), ['title' => 'required']);
            if ($validator->fails()) {
                return response()->json(['succeed' => false, 'message' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $article->update($request->all());
            $response = ['Success' => 'Article is updated'];
            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No results', Response::HTTP_UNPROCESSABLE_ENTITY]);
        }
    }

    public function destroy($id)
    {
        try {
            Article::findOrFail($id)->delete();
            return response()->json(['success' => 'Article is deleted']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No results'], Response::HTTP_FORBIDDEN);
        }
    }
}
