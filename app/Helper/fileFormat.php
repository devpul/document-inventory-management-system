<?php

if (!function_exists('getFileBadge')) {
    function getFileBadge($filename)
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $map = [
            'doc'  => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
            'docx' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
            'xls'  => ['bg' => 'bg-green-100', 'text' => 'text-green-600'],
            'xlsx' => ['bg' => 'bg-green-100', 'text' => 'text-green-600'],
            'pdf'  => ['bg' => 'bg-red-100', 'text' => 'text-red-600'],
            'png'  => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
            'jpg'  => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
            'jpeg' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
        ];

        $badge = $map[$ext] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'];

        return "<span class=\"px-2 py-1 text-xs {$badge['bg']} {$badge['text']} rounded-full font-medium\">"
                . strtoupper($ext) .
                "</span>";
    }
}
