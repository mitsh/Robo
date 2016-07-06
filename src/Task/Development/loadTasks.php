<?php
namespace Robo\Task\Development;

use Robo\Container\SimpleServiceProvider;

trait loadTasks
{
    /**
     * Return services.
     */
    public static function getDevelopmentServices()
    {
        return new SimpleServiceProvider(
            [
                'taskChangelog' => Changelog::class,
                'taskGenDoc' => GenerateMarkdownDoc::class,
                'taskGenTask' => GenerateTask::class,
                'taskSemVer' => SemVer::class,
                'taskServer' => PhpServer::class,
                'taskPackPhar' => PackPhar::class,
                'taskGitHubRelease' => GitHubRelease::class,
                'taskOpenBrowser' => OpenBrowser::class,
            ]
        );
    }

    /**
     * @param string $filename
     * @return Changelog
     */
    public function taskChangelog($filename = 'CHANGELOG.md')
    {
        return $this->task(__FUNCTION__, $filename);
    }

    /**
     * @param $filename
     * @return GenerateMarkdownDoc
     */
    public function taskGenDoc($filename)
    {
        return $this->task(__FUNCTION__, $filename);
    }

    /**
     * @param $filename
     * @return GenerateMarkdownDoc
     */
    public function taskGenTask($className, $wrapperClassName = '')
    {
        return $this->task(__FUNCTION__, $className, $wrapperClassName);
    }

    /**
     * @param string $pathToSemVer
     * @return SemVer
     */
    public function taskSemVer($pathToSemVer = '.semver')
    {
        return $this->task(__FUNCTION__, $pathToSemVer);
    }

    /**
     * @param int $port
     * @return PhpServer
     */
    public function taskServer($port = 8000)
    {
        return $this->task(__FUNCTION__, $port);
    }

    /**
     * @param $filename
     * @return PackPhar
     */
    public function taskPackPhar($filename)
    {
        return $this->task(__FUNCTION__, $filename);
    }

    /**
     * @param $tag
     * @return GitHubRelease
     */
    public function taskGitHubRelease($tag)
    {
        return $this->task(__FUNCTION__, $tag);
    }

    /**
     * @param string|array $url
     * @return OpenBrowser
     */
    public function taskOpenBrowser($url)
    {
        return $this->task(__FUNCTION__, $url);
    }
}
