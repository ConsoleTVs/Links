<?php

/*
 * This file is part of consoletvs/links.
 *
 * (c) Erik Campobadal <soc@erik.cat>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ConsoleTVs\Links\Facades;

use ConsoleTVs\Links\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * This is the links facade class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Link extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Builder::class;
    }
}
