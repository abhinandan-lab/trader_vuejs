<?php

function loadEnv($filePath)
{
    if (!file_exists($filePath)) {
        error_log("The .env file does not exist: $filePath");
        return;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parse key-value pairs
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $value = trim($parts[1]);

            // Remove surrounding quotes if present
            $value = trim($value, "\"'");

            // Set environment variable
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}
