<?php

namespace KLib2\Interfaces;

interface IPath {
    public function dir(string $endpoint = ''): string;
    public function url(string $endpoint = ''): string; 
}