<?php

/*
 * This file is part of consoletvs/links.
 *
 * (c) Erik Campobadal <soc@erik.cat>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ConsoleTVs\Links;

use Request;
use ConsoleTVs\Links\Builder\Link;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Facade;

/**
 * This is the link facade class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Builder
{
    /**
     * Return a new link instance from a url.
     *
     * @param string $url
     */
    public static function url($url)
    {
        return new Link($url);
    }

    /**
     * Return a new link instance from a route name.
     *
     * @param string $url
     */
    public static function route($name)
    {
        return new Link(route($name));
    }

    /**
     * Create a new link from the current page url.
     *
     * @param string $url
     */
    public static function track($jquery = false)
    {
        $link = new Link(Request::url());

        return $link->ajax($jquery);
    }
}
