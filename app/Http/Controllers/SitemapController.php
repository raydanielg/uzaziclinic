<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $now = Carbon::now()->toAtomString();
        
        $urls = [
            ['loc' => url('/'), 'lastmod' => $now, 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => url('/landing'), 'lastmod' => $now, 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => url('/about-us'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => url('/services'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => url('/blog'), 'lastmod' => $now, 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => url('/appointments'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => url('/contact-us'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => url('/shop'), 'lastmod' => $now, 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => url('/support/help-center'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => url('/support/faqs'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => url('/support/contact-support'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => url('/resources/guidelines'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => url('/resources/health-tips'), 'lastmod' => $now, 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => url('/resources/news'), 'lastmod' => $now, 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['loc' => url('/resources/research'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => url('/resources/staff-portal'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.4'],
        ];

        return response()->view('sitemap', [
            'urls' => $urls
        ])->header('Content-Type', 'text/xml');
    }
}
