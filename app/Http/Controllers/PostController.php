<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        $title = '';

        if(request('category')){
            $category = Category::where('slug', request('category'))->first();
            $title = ' in ' . $category->name;
        }

        if(request('author')){
            $author = User::where('username', request('author'))->first();
            $title = ' by ' . $author->name;
        }

        return view('posts',[
            "title" =>"All Posts" . $title,
            "active" => "posts",
            "posts" => Post::latest()->filter(request(['search','category']))->
            paginate(7)->withQueryString()
        ]);
    }

    public function show(Post $post)
    {
        return view('post',[
            'title' => "Single Post",
            "active" => "posts",
            'post'=> $post
        ]);
    }
}
