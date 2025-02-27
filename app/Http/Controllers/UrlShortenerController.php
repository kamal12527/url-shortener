<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Illuminate\Support\Str;

class UrlShortenerController extends Controller
{
    public function index()
    {
        return view('shortener');
    }

    public function shorten(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url|max:2048'
        ]);

        $existing = ShortUrl::where('original_url', $request->original_url)->first();

        if ($existing) {
            return response()->json(['short_url' => url($existing->short_code)]);
        }

        $shortCode = Str::random(6);

        ShortUrl::create([
            'original_url' => $request->original_url,
            'short_code' => $shortCode
        ]);

        return response()->json(['short_url' => url($shortCode)]);
    }

    public function redirect($shortCode)
    {
        $shortUrl = ShortUrl::where('short_code', $shortCode)->firstOrFail();
        return redirect()->away($shortUrl->original_url);
    }
}

