<?php
namespace Robo\Task\Docker;

use Robo\Container\SimpleServiceProvider;

trait loadTasks
{
    /**
     * Return services.
     */
    public static function getDockerServices()
    {
        return new SimpleServiceProvider(
            [
                'taskDockerRun' => Run::class,
                'taskDockerPull' => Pull::class,
                'taskDockerBuild' => Build::class,
                'taskDockerStop' => Stop::class,
                'taskDockerCommit' => Commit::class,
                'taskDockerStart' => Start::class,
                'taskDockerRemove' => Remove::class,
            ]
        );
    }

    public function taskDockerRun($image)
    {
        return $this->task(__FUNCTION__, $image);
    }
    public function taskDockerPull($image)
    {
        return $this->task(__FUNCTION__, $image);
    }
    public function taskDockerBuild($path = '.')
    {
        return $this->task(__FUNCTION__, $path);
    }
    public function taskDockerStop($cidOrResult)
    {
        return $this->task(__FUNCTION__, $cidOrResult);
    }
    public function taskDockerCommit($cidOrResult)
    {
        return $this->task(__FUNCTION__, $cidOrResult);
    }
    public function taskDockerStart($cidOrResult)
    {
        return $this->task(__FUNCTION__, $cidOrResult);
    }
    public function taskDockerRemove($cidOrResult)
    {
        return $this->task(__FUNCTION__, $cidOrResult);
    }

    public function taskDockerExec($cidOrResult)
    {
        return $this->task(__FUNCTION__, $cidOrResult);
    }
}
