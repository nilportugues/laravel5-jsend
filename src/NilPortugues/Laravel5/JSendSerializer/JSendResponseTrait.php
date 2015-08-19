<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 8/18/15
 * Time: 11:19 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Laravel5\JSendSerializer;

use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

trait JSendResponseTrait
{
    /**
     * @param string   $message
     * @param int      $code
     * @param null     $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function errorResponse($message, $code = 500, $data = null) {
        return (new HttpFoundationFactory())
            ->createResponse(new \NilPortugues\Api\JSend\Http\Message\ErrorResponse($message, $code, $data));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function failResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse(new \NilPortugues\Api\JSend\Http\Message\FailResponse($json));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function response($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse(new \NilPortugues\Api\JSend\Http\Message\Response($json));
    }
} 