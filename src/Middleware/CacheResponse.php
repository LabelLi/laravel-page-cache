<?php
/**
 * [Function Description]
 *
 * Class CacheResponse
 * @package LabelLi\Pagecache\Middleware
 * @version 0.1.0
 * @author Label label@lmw.hk
 * @date 2021-08-15
 * @since 0.1.0 2021-08-15 Label: Implemented
 */


namespace LabelLi\LaravelPageCache\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LabelLi\LaravelPageCache\Cache;

class CacheResponse {
    /**
     * The cache instance.
     *
     * @var \LabelLi\LaravelPageCache\Cache
     */
    protected $Cache;

    /**
     * Constructor.
     *
     * @var \LabelLi\LaravelPageCache\Cache  $cache
     */
    public function __construct(Cache $Cache)
    {
        $this->Cache = $Cache;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->Cache->ShouldCache($request)) {
            if ($this->Cache->IsCacheExists($request)) {
                $response = new Response();
                $response->setContent($this->Cache->LoadCache($request));
            } else {
                $response = $next($request);
                $this->Cache->SaveCache($request, $response);
            }
        } else {
            $response = $next($request);
        }

        return $response;
    }
}
