<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'author' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'read_time' => 'nullable|string|max:50',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->status === 'published' && !$request->published_at) {
            $data['published_at'] = now();
        }

        Blog::create($data);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post created successfully');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'author' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'read_time' => 'nullable|string|max:50',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();

        if ($request->title !== $blog->title) {
            $data['slug'] = Str::slug($request->title);
        }

        if ($request->status === 'published' && !$blog->published_at) {
            $data['published_at'] = now();
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post updated successfully');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post deleted successfully');
    }
}
