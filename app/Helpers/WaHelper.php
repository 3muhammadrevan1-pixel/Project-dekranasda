<?php

if (! function_exists('formatWaMessage')) {
    /**
     * Format pesan WhatsApp untuk produk
     *
     * @param  \App\Models\Produk  $produk
     * @param  string|null  $color
     * @param  string|null  $size
     * @param  int  $qty
     * @return string
     */
    function formatWaMessage($produk, $color = null, $size = null, $qty = 1) {
        return "Halo Admin, saya ingin memesan:\n" .
               "Produk: {$produk->nama}\n" .
               "Toko: " . ($produk->toko->nama ?? '-') . "\n" .
               "Alamat: " . ($produk->toko->alamat ?? '-') . "\n" .
               "Warna: " . ($color ?: '-') . "\n" .
               "Ukuran: " . ($size ?: '-') . "\n" .
               "Jumlah: {$qty}";
    }
}
