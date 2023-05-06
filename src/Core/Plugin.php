<?php

namespace KLib2\Core;

use KLib2\Interfaces\IPath;

class Plugin
{
    private IPath $path;

    public function __construct(IPath $path)
    {
        $this->path = $path;
    }

    public function load(): void
    {
        if (PluginTool::has($this->path, "controllers")) {

            foreach (PluginTool::get($this->path, "controllers") as $k => $c) {

                if (PluginTool::has($this->path, "controller_namespace")) {

                    $ns = PluginTool::get($this->path, "controller_namespace");

                    $controller = $ns . $k;

                    new $controller($this->path);
                }
            }
        }

        if (PluginTool::has($this->path, "assets")) {

            foreach (PluginTool::get($this->path, "assets") as $a) {
                if (strpos('js', $a) !== false) {
                    wp_register_style(str_replace('.', '-', $a), $this->path->dir('assets/js' . $a));
                } elseif (strpos('css', $a) !== false) {
                    wp_register_style(str_replace('.', '-', $a), $this->path->url('assets/css' . $a));
                } else {
                    /** @todo créer une exception qui dira que le fichier n'est pas un asset */
                }
            }
        }
    }
}
