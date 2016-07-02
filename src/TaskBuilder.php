<?php
namespace Robo;

use Robo\Contract\TaskInterface;
use Robo\Common\IO;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use Robo\Contract\WrappedTaskInterface;

class TaskBuilder implements ContainerAwareInterface, TaskInterface
{
    use ContainerAwareTrait;
    use LoadAllTasks;

    protected $collection;
    protected $currentTask;

    /**
     * Override TaskAccessor::builder(). By default, a new builder
     * is returned, so RoboFile::taskFoo() will create a 'foo' task
     * with its own builder.  If TaskBuilder::taskBar() is called, though,
     * then the task accessor will fetch the builder to use from this
     * method, and the new task will go into the existing builder instance.
     */
    protected function builder() {
        return $this;
    }

    /**
     * Called by the factory method of each task; adds the current
     * task to the task builder.
     */
    public function addTaskToBuilder($currentTask)
    {
        // Postpone creation of the collection until the second time
        // we are called. At that time, $this->currentTask will already
        // be populated.
        if (!$this->collection && $this->currentTask) {
            $this->collection = $this->collection();
            $this->collection->add($this->currentTask);
        }
        $this->currentTask = $currentTask;
        if ($this->collection) {
            $this->collection->add($this->currentTask);
        }
        return $this;
    }

    /**
     * Return the current task for this task builder.  Use a method
     * name that is not likely to conflict with method names in any task.
     */
    public function getTaskBuilderCurrentTask()
    {
        return $this->currentTask;
    }

    /**
     * Calling the task builder with methods of the current
     * task calls through to that method of the task.
     */
    public function __call($fn, $args)
    {
        // We need to check for methods of our traits explicitly.
        if (method_exists($this, $fn)) {
            return call_user_func_array([$this, $fn], $args);
        }
        // If the method called is a method of the current task,
        // then call through to the current task's setter method.
        $result = call_user_func_array([$this->currentTask, $fn], $args);

        // If something other than a setter method is called,
        // then return its result.
        if (isset($result) && ($result !== $this->currentTask)) {
            return $result;
        }

        return $this;
    }

    /**
     * When we run the task builder, run everything in the collection.
     */
    public function run() {
        if ($this->collection) {
            return $this->collection->run();
        }
        return $this->currentTask->run();
    }
}
