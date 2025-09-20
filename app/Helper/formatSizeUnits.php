<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('getFileSizeSafe')) {
    function getFileSizeSafe($path)
    {
        try {
            if (!Storage::disk('public')->exists($path)) {
                return null; // biar aman
            }
            return Storage::disk('public')->size($path); // int (bytes)
        } catch (\Exception $e) {
            return null; // kalau error, anggap file ga ada
        }
    }
}

if (!function_exists('formatSizeUnits')) {
    function formatSizeUnits($bytes)
    {
        if ($bytes === null) return "File Tidak Ada";

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 0) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }
}

