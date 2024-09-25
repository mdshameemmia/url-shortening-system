<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ShortLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShortLinkController extends Controller

{
    public function dashboard()
    {

        return view('dashboard', [
            'urls' => ShortLink::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->get()
        ]);
    }

    public function generateShortUrl(Request $request)
    {
        try {
            $request->validate([
                'original_url' => 'required|url'
            ]);

            ShortLink::createShortLink($request->original_url, Str::random(6));
            return redirect()->to('/dashboard');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function redirect($url)
    {
        $url = ShortLink::where('short_url', $url)->first();
        $prev_visit = $url->total_visit;

        // db update
        $total_visit = $prev_visit + 1;
        $url->total_visit = $total_visit;
        $url->save();

        return redirect()->to($url->original_url);
    }
}
