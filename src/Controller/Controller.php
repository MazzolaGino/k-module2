<?php

namespace KLib2\Controller;

use KLib2\Interfaces\IPath;
use KLib2\Tool\Filter;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    public const HOOK = 'hook';
    public const ACTION = 'action';

    public const PRIORITY = 'priority';
    public const ARGS = 'args';

    public const DOC = '\\KLib2\\Document\\Documentation::getAnnotationValue';

    public Filter $filter;

    public IPath $path;

    public function __construct(IPath $path)
    {
        $doc = self::DOC;

        foreach (get_class_methods($this) as $m) {

            $method = get_class($this) . '::' . $m;

            $action = $doc($method, self::ACTION);

            if ($action) {

                $hook = $doc($method, self::HOOK);
                $priority = $doc($method, self::PRIORITY);
                $args = $doc($method, self::ARGS);

                $action($hook, [$this, $m], $priority, $args);
            }
        }

        $this->filter = new Filter();
        $this->path = $path;
    }

    protected function render(string $template, array $params): string
    {
        $twig = new Environment(new FilesystemLoader([$this->path->dir('templates')]));

        return $twig->render($template, $params);
    }

    protected function get(string $key = ''): mixed
    {
        if (array_key_exists($key, $this->filter->getGet())) {
            return $this->filter->getGet()[$key];
        }
        return $this->filter->getGet();
    }

    protected function post(string $key = ''): mixed
    {
        if (array_key_exists($key, $this->filter->getPost())) {
            return $this->filter->getPost()[$key];
        }
        return $this->filter->getPost();
    }

    protected function file(): mixed
    {
        return $this->filter->getFile();
    }
}
