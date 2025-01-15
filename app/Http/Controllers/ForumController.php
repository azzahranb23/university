<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\ForumPost;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function show(Forum $forum)
    {
        $forum->load(['posts.user', 'project']);
        return view('forums.show', compact('forum'));
    }

    public function storePost(Request $request, Forum $forum)
    {
        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $validated['user_id'] = auth()->id();
        $forum->posts()->create($validated);

        return redirect()->back()->with('success', 'Post added successfully');
    }
}
