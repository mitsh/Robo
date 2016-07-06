<?php
namespace Robo\Task\Composer;

use Robo\Container\SimpleServiceProvider;

trait loadTasks
{
    /**
     * Return services.
     */
    public static function getComposerServices()
    {
        return new SimpleServiceProvider(
            [
                'taskComposerInstall' => Install::class,
                'taskComposerUpdate' => Update::class,
                'taskComposerDumpAutoload' => DumpAutoload::class,
                'taskComposerValidate' => Validate::class,
            ]
        );
    }

    /**
     * @param null $pathToComposer
     * @return Install
     */
    public function taskComposerInstall($pathToComposer = null)
    {
        return $this->task(__FUNCTION__, $pathToComposer);
    }

    /**
     * @param null $pathToComposer
     * @return Update
     */
    public function taskComposerUpdate($pathToComposer = null)
    {
        return $this->task(__FUNCTION__, $pathToComposer);
    }

    /**
     * @param null $pathToComposer
     * @return DumpAutoload
     */
    public function taskComposerDumpAutoload($pathToComposer = null)
    {
        return $this->task(__FUNCTION__, $pathToComposer);
    }

    /**
     * @param null $pathToComposer
     * @return Validate
     */
    public function taskComposerValidate($pathToComposer = null)
    {
        return $this->task(__FUNCTION__, $pathToComposer);
    }
}
