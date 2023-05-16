<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

function __construct()
{
    $this->middleware('auth');
}

    public function store(Request $request, $id) {

          $request->validate([
             'content' => ['required', 'min:3', 'max:200']
          ]);

          if(Auth::user() != null) {
          try {
                  Comment::create([
                        'content' => $request->content,
                        'user_id' => Auth::id(),
                        'post_id' => $id,
                  ]);
                  return redirect()->back();

          } catch(\Exception $e) {
              return redirect()->back()->with('msg', 'your comment doesnt added');
          }
        }
    }
}