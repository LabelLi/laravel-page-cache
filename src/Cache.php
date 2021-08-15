<?php
/**
 * [Function Description]
 *
 * Class Cache
 * @package LabelLi\Pagecache
 * @version 0.1.0
 * @author Label label@lmw.hk
 * @date 2021-08-15
 * @since 0.1.0 2021-08-15 Label: Implemented
 */

namespace LabelLi\LaravelPageCache;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Cache {
    protected $CachePath;
    protected $CacheTime;

    public function __construct() {
        $this->CachePath = storage_path(config('pagecache.CachePath') . '/');
        $this->CacheTime = config('pagecache.CacheTime');
    }

    public function SaveCache(Request $request, Response $response) {
        $CacheFile = $request->path() . '.cache';
        if (!File::exists($this->CachePath . $request->path())) {
            File::makeDirectory($this->CachePath . $request->path(), 0755, true);
        }
        File::put($this->CachePath . $CacheFile, $response->getContent());
    }

    public function LoadCache(Request $request) {
        $CacheFile = $request->path() . '.cache';
        return File::get($this->CachePath . $CacheFile);
    }

    public function ClearCache($URL, $Recursive = false) {
        if (File::isDirectory($this->CachePath . $URL)) {
            if ($Recursive) {
                File::deleteDirectory($this->CachePath . $URL);
            }
        }

        $CacheFile = $URL . '.cache';
        File::delete($this->CachePath . $CacheFile);
    }

    public function ClearAllCache() {
        File::deleteDirectory($this->CachePath);
    }

    public function IsCacheExists(Request $request) {
        $CacheFile = $request->path() . '.cache';

        return (
            (File::exists($this->CachePath . $CacheFile)) &&
            ((time() - $this->CacheTime) <= filemtime($this->CachePath . $CacheFile))
        );
    }

    public function ShouldCache(Request $request) {
        return (
            ($request->isMethod('GET')) &&
            ($request->query->count() == 0)
        );
    }
}
