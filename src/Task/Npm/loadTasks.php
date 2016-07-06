<?php
namespace Robo\Task\Npm;

use Robo\Container\SimpleServiceProvider;

trait loadTasks
{
    /**
     * Return services.
     */
    public static function getNpmServices()
    {
        return new SimpleServiceProvider(
            [
                'taskNpmInstall' => Install::class,
                'taskNpmUpdate' => Update::class,
            ]
        );
    }

    /**
     * @param null $pathToNpm
     * @return Install
     */
    public function taskNpmInstall($pathToNpm = null)
    {
        return $this->task(__FUNCTION__, $pathToNpm);
    }

    /**
     * @param null $pathToNpm
     * @return Update
     */
    public function taskNpmUpdate($pathToNpm = null)
    {
        return $this->task(__FUNCTION__, $pathToNpm);
    }
}
