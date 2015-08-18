<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 8/16/15
 * Time: 4:43 AM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Laravel5\JSendSerializer;

use NilPortugues\Api\JSend\JSendTransformer;
use NilPortugues\Api\Mapping\Mapper;
use NilPortugues\Serializer\Serializer;

/**
 * Class JSendSerializer.
 */
class JSendSerializer
{
    /**
     * @param array $mapping
     *
     * @return Serializer
     */
    public static function instance(array $mapping)
    {
        return new Serializer(new JSendTransformer(new Mapper($mapping)));
    }
}
