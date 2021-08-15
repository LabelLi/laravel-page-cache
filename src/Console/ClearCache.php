<?php
/**
 * [Function Description]
 *
 * Class ClearCache
 * @package LabelLi\Pagecache\Console
 * @version 0.1.0
 * @author Label label@lmw.hk
 * @date 2021-08-15
 * @since 0.1.0 2021-08-15 Label: Implemented
 */


namespace LabelLi\LaravelPageCache\Console;


use Illuminate\Console\Command;
use LabelLi\LaravelPageCache\Cache;

class ClearCache extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PageCache:clear {slug?} {--recursive}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the page cache(s).';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $Cache = $this->laravel->make(Cache::class);

        $Recursive = $this->option('recursive');
        $slug = $this->argument('slug');

        if (isset($slug)) {
            $result = $Cache->ClearCache($slug, $Recursive);
        } else {
            $result = $Cache->ClearAllCache();
        }

        if ($result) {
            $this->info("Page cache cleared for '{$slug}' " . ($Recursive ? 'Recursively' : ''));
        } else {
            $this->info("Page cache failed to clear for '{$slug}' " . ($Recursive ? 'Recursively' : '') . 'Most like that the permission is not correct.');
        }
    }
}
