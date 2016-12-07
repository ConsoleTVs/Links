<?php

namespace ConsoleTVs\Links\Controllers;

use Crypt;
use Illuminate\Http\Request;
use ConsoleTVs\Links\Models\Link;
use ConsoleTVs\Links\Models\View;
use App\Http\Controllers\Controller;

class LinksController extends Controller
{
    /**
     * Show the login page.
     */
    public function showLogin()
    {
        if (session('links.password') && Crypt::decrypt(session('links.password')) == config('links.password')) {
            return redirect()->route('links::links');
        }

        return view('links::login');
    }

    /**
     * Login the user.
     */
    public function login(Request $request)
    {
        session(['links.password' => Crypt::encrypt($request->input('password'))]);

        if (Crypt::decrypt(session('links.password')) != config('links.password')) {
            return redirect()->route('links::login')->with('msg', 'The password is not correct');
        }

        return redirect()->route('links::links');
    }

    /**
     * Logout function.
     */
    public function logout(Request $request)
    {
        $request->session()->forget('links.password');

        return redirect()->route('links::links');
    }

    /**
     * Show all the links statistics.
     */
    public function links()
    {
        return view('links::links');
    }

    /**
     * Show a single link statistics.
     *
     * @param int $id
     */
    public function link($slug)
    {
        $link = Link::where('slug', $slug)->first();

        if (! $link) {
            abort(404, 'The link was not found');
        }

        return view('links::link', ['link' => $link]);
    }

    /**
     * Show a single link statistics.
     *
     * @param int $id
     */
    public function specific($slug, $specific, $specific_value)
    {
        $link = Link::where('slug', $slug)->first();

        if (! $link) {
            abort(404, 'The link was not found');
        }

        $views = View::where($specific, $specific_value)->orderBy('id', 'desc')->get();

        if (! $views->toArray()) {
            abort(404, 'No views found');
        }

        $raw_specific_value = $specific_value;

        // Fancy specific_value if it's a language
        $countries = json_decode(file_get_contents(__DIR__.'/../countries.json'), true);
        foreach ($countries as $country) {
            if ($country['code'] == $specific_value) {
                $specific_value = explode(' ', str_replace(';', '', $country['name']))[0];
                break;
            }
        }

        return view('links::specific', [
            'link' => $link,
            'views' => $views,
            'specific' => $specific,
            'specific_value' => $specific_value,
            'raw_specific_value' => $raw_specific_value,
        ]);
    }

    /**
     * Redirects the user to the link.
     *
     * @param string $slug
     */
    public function redirect($slug)
    {
        if (! $link = Link::where('slug', $slug)->first()) {
            abort(404, 'Unable to find this link');
        }

        $link->addView();

        return redirect($link->url);
    }
}
