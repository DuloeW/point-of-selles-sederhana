<?php
// Debug: pastikan variabel $color ada
if (!isset($color)) {
    $color = 'green';
}

// Tentukan inline style berdasarkan warna
$colorStyles = [
    'blue' => 'bg-gradient-to-br from-blue-500 to-blue-700 ',
    'green' => 'bg-gradient-to-br from-green-500 to-green-700',
    'yellow' => 'bg-gradient-to-br from-yellow-500 to-yellow-700',
    'red' => 'bg-gradient-to-br from-red-500 to-red-700',
    'orange' => 'bg-gradient-to-br from-orange-500 to-orange-700'
];

// Pastikan ada fallback yang jelas
$cardStyle = array_key_exists($color, $colorStyles) ? $colorStyles[$color] : $colorStyles['green'];
?>

<div class="<?= $cardStyle ?> rounded-xl p-6 shadow-md">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-blue-100 text-sm font-medium"><?= $title ?></p>
            <p class="text-3xl font-bold text-blue-100 mt-1"><?= $value ?></p>
            <p class="text-blue-100 text-sm mt-1"><?= $suffix ?></p>
        </div>
        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center shadow-lg">
            <i class="<?= $icon ?> text-<?= $color ?>-600 text-xl"></i>
        </div>
    </div>
</div>