<?php
namespace Robo\Task\File;

use Robo\Collection\Temporary;
use Robo\Container\SimpleServiceProvider;

trait loadTasks
{
    /**
     * Return services.
     */
    public static function getFileServices()
    {
        return new SimpleServiceProvider(
            [
                'taskConcat' => Concat::class,
                'taskReplaceInFile' => Replace::class,
                'taskWriteToFile' => Write::class,
                'taskTmpFile' => TmpFile::class,
            ]
        );
    }

    /**
     * @param $files
     * @return Concat
     */
    public function taskConcat($files)
    {
        return $this->task(__FUNCTION__, $files);
    }

    /**
     * @param $file
     * @return Replace
     */
    public function taskReplaceInFile($file)
    {
        return $this->task(__FUNCTION__, $file);
    }

    /**
     * @param $file
     * @return Write
     */
    public function taskWriteToFile($file)
    {
        return $this->task(__FUNCTION__, $file);
    }

    /**
     * @param $prefix
     * @param $base
     * @param $includeRandomPart
     * @return TmpFile
     */
    public function taskTmpFile($filename = 'tmp', $extension = '', $baseDir = '', $includeRandomPart = true)
    {
        return $this->task(__FUNCTION__, $filename, $extension, $baseDir, $includeRandomPart);
    }
}
