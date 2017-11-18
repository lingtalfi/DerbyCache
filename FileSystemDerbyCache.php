<?php


namespace DerbyCache;

use Bat\FileSystemTool;

/**
 * This DerbyCache uses the fileSystem as its "memory".
 *
 */
class FileSystemDerbyCache extends DerbyCache
{

    private $rootDir;

    public function __construct()
    {
        parent::__construct();
        $this->rootDir = "/tmp";
    }

    public function setRootDir($rootDir)
    {
        $this->rootDir = $rootDir;
        return $this;
    }


    //--------------------------------------------
    //
    //--------------------------------------------
    public function get($cacheIdentifier, callable $cacheItemGenerator)
    {
        $this->hook('onCacheStart', $cacheItemGenerator);
        $file = $this->rootDir . "/" . $cacheIdentifier . ".txt";
        if (file_exists($file)) {

            $this->hook('onCacheHit', $cacheItemGenerator);
            $this->hook('onCacheEnd', $cacheItemGenerator);
            return unserialize(file_get_contents($file));
        }

        $ret = call_user_func($cacheItemGenerator);
        $data = serialize($ret);
        FileSystemTool::mkfile($file, $data);
        $this->hook('onCacheCreate', $cacheItemGenerator);
        $this->hook('onCacheEnd', $cacheItemGenerator);
        return $ret;
    }

    public function deleteByPrefix($prefix)
    {
        $file = $this->rootDir . "/" . $prefix;
        $baseDir = dirname($file);
        $filePrefix = basename($file);
        if (is_dir($baseDir)) {
            $files = scandir($baseDir);
            foreach ($files as $file) {
                if ('.' !== $file && '..' !== $file) {
                    if (0 === strpos($file, $filePrefix)) {
                        $realFile = $baseDir . "/" . $file;
                        unlink($realFile);
                    }
                }
            }
        }
    }


    //--------------------------------------------
    //
    //--------------------------------------------
    protected function hook($hookName, $cacheIdentifier) // override me
    {

    }
}