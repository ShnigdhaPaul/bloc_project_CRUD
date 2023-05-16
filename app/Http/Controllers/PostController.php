<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts= Post::orderBy('id','desc')->paginate(3);
       
        return view('post.index',compact('posts'));
    
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3', ''],
            'content' => ['required', 'min:5'],
             'file'=>['required', 'image', 'mimes:png,jpg', 'max:2048']
             //'file'=>['required', 'mimes:pdf', 'max:2048']
     ]);

     try {
        if($request->hasFile('file'))
        {
           $image=$request->file('file');
           $imageName= $image->getClientOriginalName().'.'.time();
           Storage::disk('public')->putFileAs('images',$image, $imageName);
        }
       Post::create([
           'title' => $request->input('title'),
           'content' => $request->input('content'),
           'user_id' => Auth::id(),
           'file'=> $imageName,
       ]);

       return redirect()->route('post.index')->with('msg', 'post has beed created successfully');

      }catch(\Exception $e) {
           return redirect()->back()->with('msg', 'post not added');
       }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        $comments = Comment::where('post_id' , $id)->get();
        return view('post.show', compact(['post', 'comments']));$post = Post::find($id);
        
         return view('post.show', compact(['post']));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $post = Post::find($id);
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:20'],
            'content' => ['required', 'min:5'],
     ]);

     try {
        $myPost = Post::find($id);

        if($request->hasFile('file')) {
            unlink(public_path().'/storage/images/'.$myPost->file);
            $image = $request->file('file');
            $imageName = $image->getClientOriginalName();
            Storage::disk('public')->putFileAs('images', $image, $imageName);


       $myPost->update([
           'title' => $request->input('title'),
           'content' => $request->input('content'),
           'user_id' => Auth::id(),
           'file' => $imageName,
       ]);

       return redirect()->route('post.index')->with('msg', 'post has beed updated successfully');
    } else {
        $myPost->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),

        ]);
    }
       } catch(\Exception $e) {
           return redirect()->back()->with('msg', 'post not updated');
       }

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            $owner = $post->user->id;
            $authUser = Auth::id();
            
            if($owner == $authUser) {
                if(is_file(public_path().'/storage/images/'.$post->file)){
            unlink(public_path().'/storage/images/'.$post->file);


                    $post->delete();
                    return redirect()->back()->with('msg', 'post has been deleted successfully');
            }} else {
               return redirect()->back()->with('msg', 'it is not your post');
            }

        } catch(\Exception $e) {
           return redirect()->back()->with('msg', 'post not deleted');
        }
    }
    public function dashboard() {
        $authUser = Auth::user();
        $myPosts = $authUser-> posts()->paginate(3);
        return view('post.dashboard', compact('myPosts'));
    }

}