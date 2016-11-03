<?php

namespace ConsoleTVs\Links\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table = 'link_views';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'link_id', 'language', 'browser', 'browser_version', 'os', 'os_version', 'ip',
    ];

    public function languageFancy()
    {
        $countries = json_decode(file_get_contents(__DIR__.'/../countries.json'), true);
        foreach ($countries as $country) {
            if ($country['code'] == $this->language) {
                return explode(' ', str_replace(';', '', $country['name']))[0];
            }
        }

        return $this->language;
    }
}
