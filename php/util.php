<?php
function doesExist($url): bool
{
    $file_headers = @get_headers($url);
    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        return false;
    }
    return true;
}

function removeDocumentRootFromPath($path): string
{
    $documentRoot = $_SERVER['DOCUMENT_ROOT'];
    return str_replace($documentRoot, "", $path);
}

function safeName($str): string
{
    return str_replace(" ", "-", strtolower($str));
}

function getDirs($parentDir): array|false
{
    // Check if the directory exists
    if (is_dir($parentDir)) {
        // Get all files and directories
        $files = scandir($parentDir);
        $dirs = [];

        foreach ($files as $file) {
            // Skip the special directories . and ..
            if ($file === '.' || $file === '..') {
                continue;
            }

            // Get the full path of the file
            $path = $parentDir . '/' . $file;

            // Check if it's a directory
            if (is_dir($path)) {
                // It's a directory, add it to the array
                $dirs[] = $path;
            }
        }

        return $dirs;
    }
    return false;
}