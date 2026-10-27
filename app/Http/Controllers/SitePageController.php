<?php

namespace App\Http\Controllers;

use App\Models\SitePage;
use App\Models\SiteSetting;
use Illuminate\View\View;

class SitePageController extends Controller
{
    public function show(string $slug): View
    {
        $page = SitePage::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('store.static', [
            'pageTitle' => $page->title,
            'pageText' => $page->content ?? '',
            'metaTitle' => $page->meta_title ?: $page->title . ' | موبیکس هاب',
            'metaDescription' => $page->meta_description,
            'siteSettings' => SiteSetting::query()->pluck('value', 'key')->all(),
        ]);
    }
}
