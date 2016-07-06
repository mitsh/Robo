<?php
namespace Robo\Task\Archive;

use Robo\Container\SimpleServiceProvider;

trait loadTasks
{
    /**
     * Return services.
     */
    public static function getArchiveServices()
    {
        return new SimpleServiceProvider(
            [
                'taskExtract' => Extract::class,
                'taskPack' => Pack::class,
            ]
        );
    }

    /**
     * @param $filename
     *
     * @return Archive
     */
    public function taskPack($filename)
    {
        return $this->task(__FUNCTION__, $filename);
    }

    /**
     * @param $filename
     *
     * @return Extract
     */
    public function taskExtract($filename)
    {
        return $this->task(__FUNCTION__, $filename);
    }
}
