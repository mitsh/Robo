<?php
namespace Robo\Task\Assets;

use Robo\Container\SimpleServiceProvider;

trait loadTasks
{
    /**
     * Return services.
     */
    public static function getAssetsServices()
    {
        return new SimpleServiceProvider(
            [
                'taskMinify' => Minify::class,
                'taskImageMinify' => ImageMinify::class,
                'taskLess' => Less::class,
                'taskScss' => Scss::class,
            ]
        );
    }

    /**
    * @param $input
    * @return Minify
    */
    public function taskMinify($input)
    {
        return $this->task(__FUNCTION__, $input);
    }

    /**
     * @param $input
     * @return ImageMinify
     */
    public function taskImageMinify($input)
    {
        return $this->task(__FUNCTION__, $input);
    }

   /**
    * @param $input
    * @return Less
    */
    public function taskLess($input)
    {
        return $this->task(__FUNCTION__, $input);
    }

    /**
     * @param $input
     * @return Scss
     */
    public function taskScss($input)
    {
        return $this->task(__FUNCTION__, $input);
    }
}
