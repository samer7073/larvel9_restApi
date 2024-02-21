<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'status' => true,
            'posts' => $posts
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            if($request->has('image')){
                $imageName = time().'.'.$request->image->extension();
                Storage::disk('public')->put($imageName, file_get_contents($request->image));

                $post = Post::create([
                    'title' => $request->title,
                    'content' => $request->content,
                    'image' => $imageName,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Post Created successfully',
                    'post' => $post
                ], 201);
            }else{
                $post = Post::create([
                    'title' => $request->title,
                    'content' => $request->content,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Post Created successfully',
                    'post' => $post
                ], 201);
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
        $post = Post::findOrFail($post->id);

        return response()->json([
            'status' => true,
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post = Post::findOrFail($post->id);

        if($request->has('image')){
            $imageName = time().'.'.$request->image->extension();
            Storage::disk('public')->put($imageName, file_get_contents($request->image));

            $post->update([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $imageName,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Post Updated successfully',
                'post' => $post
            ], 201);
        }else{
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Post Updated successfully',
                'post' => $post
            ], 201);
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
        $post = Post::findOrFail($post->id);
        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'Post Deleted successfully'
        ]);

    }
}
