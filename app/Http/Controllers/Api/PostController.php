<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PostResource;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store','update');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try{
            $posts = Post::all();
            $data = PostResource::collection($posts);
            return response()->json([
                'success' => true,
                'msg' => 'all data',
                'posts' => $data,
            ]);
        }catch (Exception $ex) { // Anything that went wrong
            abort(500, $ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        //
        try{
            $data = $request->all();
            $data['post_creator'] =auth()->id();
            $post = Post::create($data);
            $post->save();
            return response()->json([
                'success' => true,
                'msg' => 'created successfully ',
                'new post' => $post,
            ]);
        }catch (Exception $ex) { // Anything that went wrong
            abort(500, $ex->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        try{
            $post = new PostResource($post);
            return response()->json([
                'success' => true,
                'msg' => 'show Post ',
                'post' => $post,
            ]);
        }catch (Exception $ex) { // Anything that went wrong
            abort(500, $ex->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
        try{
            $data = $request->all();
            $updatedPost = $post->update($data);
            $post = new PostResource($post);
            return response()->json([
                'success' => true,
                'msg' => 'updated successfully Post ',
                'post' => $post,
            ]);
        }
        catch (Exception $ex) { // Anything that went wrong
            abort(500, $ex->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        try{
            $post->delete();
            return response()->json([
                'success' => true,
                'msg' => 'deleted successfully Post ',
                'post' => [],
            ]);
        }catch (Exception $ex) { // Anything that went wrong
            abort(500, $ex->getMessage());
        }

    }
}