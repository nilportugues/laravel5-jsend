<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 8/16/15
 * Time: 4:27 AM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Laravel5\JSendSerializer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class JSendSerializer.
 */
class JSendSerializer extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return '\NilPortugues\Serializer\Serializer';
    }
}
