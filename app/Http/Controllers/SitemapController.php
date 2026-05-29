<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        // Fetch dynamic content
        $posts = Blog::where('status', 'published')
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at']);
        
        $services = Service::where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at']);
        
        $products = Product::where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at']);

        $content = view('sitemap', [
            'posts' => $posts,
            'services' => $services,
            'products' => $products,
        ])->render();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $content;

        return response($xml)
            ->header('Content-Type', 'text/xml; charset=UTF-8');
    }
}
