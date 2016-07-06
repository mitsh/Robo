<?php
namespace Robo\Task\ApiGen;

use Robo\Container\SimpleServiceProvider;

trait loadTasks
{
    /**
     * Return services.
     */
    public static function getApiGenServices()
    {
        return new SimpleServiceProvider(
            [
                'taskApiGen' => ApiGen::class,
            ]
        );
    }

    /**
     * @param null $pathToApiGen
     * @return \Robo\Task\ApiGen\ApiGen
     */
    public function taskApiGen($pathToApiGen = null)
    {
        return $this->task(__FUNCTION__, $pathToApiGen);
    }
}
