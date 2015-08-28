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
use NilPortugues\Serializer\DeepCopySerializer;

/**
 * Class JSendSerializer.
 */
class JSendSerializer extends DeepCopySerializer
{
    /**
     * @param JSendTransformer $jSendTransformer
     */
    public function __construct(JSendTransformer $jSendTransformer)
    {
        parent::__construct($jSendTransformer);
    }
}
