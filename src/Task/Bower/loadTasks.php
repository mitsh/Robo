<?php
namespace Robo\Task\Bower;

use Robo\Container\SimpleServiceProvider;

trait loadTasks
{
    /**
     * Return services.
     */
    public static function getBowerServices()
    {
        return new SimpleServiceProvider(
            [
                'taskBowerInstall' => Install::class,
                'taskBowerUpdate' => Update::class,
            ]
        );
    }

    /**
     * @param null $pathToBower
     * @return Install
     */
    public function taskBowerInstall($pathToBower = null)
    {
        return $this->task(__FUNCTION__, $pathToBower);
    }

    /**
     * @param null $pathToBower
     * @return Update
     */
    public function taskBowerUpdate($pathToBower = null)
    {
        return $this->task(__FUNCTION__, $pathToBower);
    }
}
