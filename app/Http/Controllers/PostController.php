<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\Http\Middleware\VerifyCategoriesCount;
use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Tag;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $image = $request->image->store('posts');
        
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'published_at' => $request->publish_at,
            'image' => $image,
            'category_id' => $request->category
        ]);

        if($request->tags){
            $post->tags()->attach($request->tags);
        }

        session()->flash('success', 'Post has been created successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only([
            'title',
            'description',
            'content',
            'publish_at'
        ]);

        if($request->hasFile('image')){
            $image = $request->image->store('posts');

            // delete old image
            $post->deleteImage();
        }
        if(isset($image)){
            $data['image'] = $image;
        }

        if($request->tags){
            $post->tags()->sync($request->tags);
        }

        $post->update($data);

        session()->flash('success', 'Post has been updated successfully');

        return redirect(route('posts.index'));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        if($post->trashed()){         
            
            $post->forceDelete();
        }else{
            $post->delete();
        }
        
        session()->flash('success', 'Post has been deleted successfully');

        return redirect(route('posts.index'));
    }

    public function trashed(){

        $trashed = Post::onlyTrashed()->get();
        return view('posts.index')->with('posts',$trashed);
    }

    public function restore($id){
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();  
        $post->restore();
        return redirect()->back();
    }
}
