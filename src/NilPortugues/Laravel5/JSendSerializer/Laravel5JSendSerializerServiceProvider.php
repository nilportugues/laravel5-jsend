<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 8/15/15
 * Time: 5:45 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Laravel5\JSendSerializer;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use NilPortugues\Api\JSend\JSendTransformer;
use NilPortugues\Api\Mapping\Mapper;

class Laravel5JSendSerializerServiceProvider extends ServiceProvider
{
    const PATH = '/../../../config/jsend.php';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([__DIR__.self::PATH => config('jsend.php')]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.self::PATH, 'jsend');
        $this->app->singleton(\NilPortugues\Laravel5\JSendSerializer\JSendSerializer::class, function ($app) {
                $mapping = $app['config']->get('jsend');
                $key = md5(json_encode($mapping));
                $cachedMapping = Cache::get($key);
                if(!empty($cachedMapping)) {
                    return unserialize($cachedMapping);
                }
                self::parseNamedRoutes($mapping);
                $serializer = new JSendSerializer(new JSendTransformer(new Mapper($mapping)));
                Cache::put($key, serialize($serializer),60*60*24);
                return $serializer;
            });
    }
    /**
     * @param array $mapping
     *
     * @return mixed
     */
    private static function parseNamedRoutes(array &$mapping)
    {
        foreach ($mapping as &$map) {
            self::parseUrls($map);
        }
    }
    
    /**
     * @param array $map
     */
    private static function parseUrls(array &$map)
    {
        if (!empty($map['urls'])) {
            foreach ($map['urls'] as &$namedUrl) {
                $namedUrl = urldecode(route($namedUrl));
            }
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['jsend'];
    }
}
