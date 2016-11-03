<?php

/*
 * This file is part of consoletvs/links.
 *
 * (c) Erik Campobadal <soc@erik.cat>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ConsoleTVs\Links\Builder;

use ConsoleTVs\Links\Models\Link as Linker;

/**
 * This is the link class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Link
{
    public $link;

    /**
     * Create a new link instance.
     *
     * @param string $url
     */
    public function __construct($url)
    {
        if (! $link = Linker::where('url', $url)->first()) {
            $link = Linker::create([
                'url'   => $url,
                'slug'  => $this->randomString(6),
            ]);
        }

        $this->link = $link;
    }

    /**
     * Return a random string.
     *
     * @param int $length
     */
    public function randomString($length = 10)
    {
        return str_random($length);
    }

    /**
     * Returns the link.
     */
    public function __toString()
    {
        return $this->link->shortered();
    }

    /**
     * Returns the javascript code to send a and ajax request to the short url.
     */
    public function ajax($jquery = false)
    {
        $url = $this->link->shortered();

        $code = $jquery ? "<script src='https://code.jquery.com/jquery-3.1.1.min.js' integrity='sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=' crossorigin='anonymous'></script>" : '';

        $code .= '<script>';
        $code .= "$.get('$url');";
        $code .= '</script>';

        return $code;
    }
}
