<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = Blog::published()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        $recentPosts = Blog::published()
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.blog.index', compact('blogs', 'categories', 'recentPosts'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $recentPosts = Blog::published()
            ->where('id', '!=', $blog->id)
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();

        $relatedPosts = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('category', $blog->category)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $categories = Blog::published()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return view('pages.blog.show', compact('blog', 'recentPosts', 'relatedPosts', 'categories'));
    }
}
