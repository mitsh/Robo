<?php
namespace Robo\Task\Base;

use Robo\Container\SimpleServiceProvider;

trait loadTasks
{
    /**
     * Return services.
     */
    public static function getBaseServices()
    {
        return new SimpleServiceProvider(
            [
                'taskExec' => Exec::class,
                'taskExecStack' => ExecStack::class,
                'taskParallelExec' => ParallelExec::class,
                'taskSymfonyCommand' => SymfonyCommand::class,
                'taskWatch' => Watch::class,
            ]
        );
    }

    /**
     * @param $command
     * @return Exec
     */
    public function taskExec($command)
    {
        return $this->task(__FUNCTION__, $command);
    }

    public function taskExecStack()
    {
        return $this->task(__FUNCTION__);
    }

    /**
     * @return ParallelExec
     */
    public function taskParallelExec()
    {
        return $this->task(__FUNCTION__);
    }

    /**
     * @param $command
     * @return SymfonyCommand
     */
    public function taskSymfonyCommand($command)
    {
        return $this->task(__FUNCTION__, $command);
    }

    /**
     * @return Watch
     */
    public function taskWatch()
    {
        return $this->task(__FUNCTION__, $this);
    }
}
