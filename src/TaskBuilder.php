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
    protected $taskProviders = [];
    protected $addFunction = 'add';

    /**
     * Override TaskAccessor::builder(). By default, a new builder
     * is returned, so RoboFile::taskFoo() will create a 'foo' task
     * with its own builder.  If TaskBuilder::taskBar() is called, though,
     * then the task accessor will fetch the builder to use from this
     * method, and the new task will go into the existing builder instance.
     */
    protected function builder()
    {
        return $this;
    }

    /**
     * Add any object that contains a selection of `taskFoo` methods
     * to make these available via the task builder.
     */
    public function addTaskProvider($taskProvider)
    {
        $this->taskProviders[] = $taskProvider;
    }

    /**
     * The next task added to this builder will be added as a rollback.
     * Example: `$this->builder()->rollback()->taskDeleteDir(...);
     * @return type
     */
    public function rollback()
    {
        // Ensure that we have a collection if we are going to add
        // a rollback function.
        $this->getCollection();
        // The next task added will be a rollback task rather than
        // an ordinary task for execution.
        $this->addFunction = 'rollback';
    }

    /**
     * Add a function callback as a rollback task.
     * @param callable $rollbackCode
     * @return type
     */
    public function rollbackCode(callable $rollbackCode)
    {
        $this->getCollection()->rollbackCode($rollbackCode);
    }

    public function addCode(callable $code)
    {
        $this->getCollection()->addCode($code);
    }

    /**
     * Called by the factory method of each task; adds the current
     * task to the task builder.
     */
    public function addTaskToBuilder($currentTask)
    {
        // Postpone creation of the collection until the second time
        // we are called. At that time, $this->currentTask will already
        // be populated.  We call 'getCollection()' so that it will
        // create the collection and add the current task to it.
        if (!$this->collection && $this->currentTask) {
            $this->getCollection();
        }
        $this->currentTask = $currentTask;
        if ($this->collection) {
            $this->addToCollection($currentTask);
        }
        return $this;
    }

    /**
     * Return the collection of tasks associated with this builder.
     *
     * @return Collection
     */
    protected function getCollection()
    {
        return $this->addToCollection($this->currentTask);
    }

    protected function addToCollection($task)
    {
        if (!$this->collection) {
            $this->collection = $this->collection();
        }
        if ($task) {
            $fn = $this->addFunction;
            $this->collection->$fn($task);
            $this->addFunction = 'add';
        }
        return $this->collection;
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
        // All of the standard Robo tasks are available as part of the
        // builder, thanks to the `use LoadAllTasks` directive at the
        // top of this class.  To add custom tasks, use `addTaskProvider`
        // to add an instance of an object that contains `task` methods.
        // The Robo runner does this automatically for RoboFiles;
        // @see TaskAccessor::builder()
        if (preg_match('#^task#', $fn)) {
            foreach ($this->taskProviders as $taskProvider) {
                if (method_exists($taskProvider, $fn)) {
                    $task = call_user_func_array([$taskProvider, $fn], $args);
                    return $this->addTaskToBuilder($task);
                }
            }
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
     * Construct the desired task via the container and add it to this builder.
     */
    public function build($name, $args)
    {
        $task = $this->getContainer()->get($name, $args);
        if (!$task) {
            throw new RuntimeException("Can not construct task $name");
        }
        return $this->addTaskToBuilder($task);
    }

    /**
     * When we run the task builder, run everything in the collection.
     */
    public function run()
    {
        if ($this->collection) {
            return $this->collection->run();
        }
        return $this->currentTask->run();
    }
}
