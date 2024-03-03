<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Http\Requests\PostRequest;


class PostController extends Controller
{
     // 一覧ページ
    public function index()
{
    $posts = Auth::user()->posts()->orderBy('created_at', 'desc')->get();

    return view('posts.index', compact('posts'));
    }
    // 詳細ページ
    public function show(Post $post)
{
    return view('posts.show', compact('post'));
    }
    // 作成ページ
    public function create()
{
    return view('posts.create');
}
// 作成機能
public function store(PostRequest $request)
{
    $post = new Post();
    $post->title = $request->input('title');
    $post->content = $request->input('content');
    $post->user_id = Auth::id();
    $post->save();

return redirect()->route('posts.index')->with('flash_message', '投稿が完了しました。');
}
// 編集ページ
    public function edit(Post $post)
{
    if ($post->user_id !== Auth::id()) {
    return redirect()->route('posts.index')->with('error_message', '不正なアクセスです。');
}
    return view('posts.edit', compact('post'));
}
 // 更新機能
    public function update(PostRequest $request, Post $post)
{
    if ($post->user_id !== Auth::id()) {
    return redirect()->route('posts.index')->with('error_message', '不正なアクセスです。');
 }
    $post->title = $request->input('title');
    $post->content = $request->input('content');
    $post->save();
    return redirect()->route('posts.show', $post)->with('flash_message', '投稿を編集しました。');
}
// 削除機能
    public function destroy(Post $post) {
    if ($post->user_id !== Auth::id()) {
    return redirect()->route('posts.index')->with('error_message', '不正なアクセスです。');
}
    $post->delete();
    return redirect()->route('posts.index')->with('flash_message', '投稿を削除しました。');
}
        
 


}
