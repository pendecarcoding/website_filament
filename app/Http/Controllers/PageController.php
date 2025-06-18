<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function index(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->first();
        return view('frontend.page.page-noside', compact('page'));
    }
    public function faq(Request $request)
    {
        return view('frontend.page.faq');
    }
}
