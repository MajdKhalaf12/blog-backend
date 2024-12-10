<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    //get all post comments
    public function index($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post not found'
            ], 403);
        }

        return response([
            'comments' => $post->comments()->with('user:id,name,image')->get()
        ], 200);
    }

    //create comment
    public function store(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post not Found'
            ], 403);
        }

        $attrs = $request->validate([
            'comment' => 'required|string',
        ]);


        Comment::create([
            'comment' => $attrs['comment'],
            'post_id' => $id,
            'user_id' => auth()->user()->id
        ]);

        return response([
            'message' => 'Comment Created Successfully'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response([
                'message' => 'Comment Not found'
            ], 403);
        }

        if ($comment->user_id != auth()->user()->id) {
            return response([
                'message' => 'permission denied'
            ], 403);
        }

        $attrs = $request->validate([
            'comment' => 'required|string',
        ]);

        $comment->update([
            'comment' => $attrs['comment'],
        ]);

        return response([
            'message' => 'Comment updated'
        ], 200);
    }

    function destroy(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response([
                'message' => 'Comment Not found'
            ], 403);
        }

        $attrs = $request->validate([
            'comment' => 'required|string',
        ]);


    }
}
