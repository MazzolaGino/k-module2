<?php

namespace KLib2\Core;

use KLib2\Interfaces\IPath;

class PluginTool
{
    public static function getConfig(IPath $path): array
    {
        return json_decode(file_get_contents($path->dir('config.json')), true);
    }

    public static function has(IPath $path, string $key): bool
    {
        return array_key_exists($key, self::getConfig($path));
    }

    public static function get(IPath $path, string $key): mixed
    {
        return self::getConfig($path)[$key];
    }
}
