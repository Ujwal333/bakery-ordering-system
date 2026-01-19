<?php
$dir = __DIR__ . '/Backend/resources/views/admin';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $newContent = str_replace(
            ["@extends('layouts.admin')", '@extends("layouts.admin")'],
            ["@extends('admin.layout')", "@extends('admin.layout')"],
            $content
        );
        if ($content !== $newContent) {
            file_put_contents($file->getPathname(), $newContent);
            echo "Updated: " . $file->getFilename() . "\n";
        }
    }
}
echo "Done.\n";
