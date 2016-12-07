<?php

namespace ConsoleTVs\Links\Models;

use Illuminate\Database\Eloquent\Model;
use Unicodeveloper\Identify\Facades\IdentityFacade as Identify;

class Link extends Model
{
    protected $table = 'links';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'slug',
    ];

    /**
     * Returns the shortered link.
     */
    public function shortered()
    {
        return route('links::redirect', ['slug' => $this->slug]);
    }

    /**
     * Returns the link views.
     */
    public function views()
    {
        return $this->hasMany('ConsoleTVs\Links\Models\View');
    }

    /**
     * Returns the link unique views.
     */
    public function uniqueViews()
    {
        return $this->views->unique('ip');
    }

    /**
     * Returns the link total views number.
     */
    public function totalViews()
    {
        return count($this->views);
    }

    /**
     * Returns the link total unique views number.
     */
    public function totalUniqueViews()
    {
        return count($this->uniqueViews());
    }

    /**
     * Returns the link browsers.
     */
    public function usedBrowsers()
    {
        $results = [];

        foreach ($this->views as $view) {
            array_key_exists($view->browser, $results) ? $results[$view->browser]++ : $results[$view->browser] = 1;
        }

        return $results;
    }

    /**
     * Returns the link most used browser.
     */
    public function mostUsedBrowser()
    {
        $max = 0;
        $max_browser = null;

        foreach ($this->usedBrowsers() as $browser => $count) {
            if ($count >= $max) {
                $max = $count;
                $max_browser = $browser;
            }
        }

        return $max_browser;
    }

    /**
     * Returns the link OSs (Operating Systems).
     */
    public function usedOSs()
    {
        $results = [];

        foreach ($this->views as $view) {
            array_key_exists($view->os, $results) ? $results[$view->os]++ : $results[$view->os] = 1;
        }

        return $results;
    }

    /**
     * Returns the link most used OS (Operating System).
     */
    public function mostUsedOS()
    {
        $max = 0;
        $max_os = null;

        foreach ($this->usedOSs() as $os => $count) {
            if ($count >= $max) {
                $max = $count;
                $max_os = $os;
            }
        }

        return $max_os;
    }

    /**
     * Returns the link OSs (Operating Systems).
     *
     * @param bool $fancy
     */
    public function usedLanguages($fancy = false)
    {
        $collection = collect($this->views->toArray())->groupBy('language')->map(function ($item, $key) {
            return count($item);
        });

        if ($fancy) {
            $collection = $collection->groupBy(function ($item, $key) {
                $countries = json_decode(file_get_contents(__DIR__.'/../countries.json'), true);
                foreach ($countries as $country) {
                    if ($country['code'] == $key) {
                        return explode(' ', str_replace(';', '', $country['name']))[0];
                    }
                }

                return $key;
            })->map(function ($item, $key) {
                return count($item);
            });
        }

        return $collection->toArray();
    }

    /**
     * Returns the link most used OS (Operating System).
     *
     * @param bool $fancy
     */
    public function mostUsedLanguage($fancy = false)
    {
        $max = collect($languages = $this->usedLanguages())->max();

        foreach ($languages as $lang => $views) {
            if ($views == $max) {
                if ($fancy) {
                    $countries = json_decode(file_get_contents(__DIR__.'/../countries.json'), true);
                    foreach ($countries as $country) {
                        if ($country['code'] == $lang) {
                            return explode(' ', str_replace(';', '', $country['name']))[0];
                        }
                    }
                }

                return $lang;
            }
        }
    }

    /**
     * Adds a new view to the link.
     */
    public function addView()
    {
        $view = View::create([
            'link_id'           => $this->id,
            'language'          => Identify::lang()->getLanguage(),
            'browser'           => Identify::browser()->getName(),
            'browser_version'   => Identify::browser()->getVersion(),
            'os'                => Identify::os()->getName(),
            'os_version'        => Identify::os()->getVersion(),
            'ip'                => $this->getIP(),
        ]);
    }

    /**
     * Gets the real client IP.
     */
    public function getIP()
    {
        if (! empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {   //check ip from cloudflare
          $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (! empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
          $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }
}
