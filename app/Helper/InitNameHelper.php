<?php

    function getInitialName($nama, $limit = 3)
    {
        return collect(
            explode(' ', $nama)// hapus setiap spasi
            )
            ->take($limit)
            ->map(fn($n) => strtoupper(substr($n, 0, 1)))
            ->implode('');
    }
    // jangan lupa DAFTARKAN HELPER di composer.json bagian autoload->files
    // jangan lupa juga setelah itu ketik "composer dump-autoload"
?>