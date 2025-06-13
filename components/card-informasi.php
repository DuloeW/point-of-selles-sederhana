<?php
// Debug: pastikan variabel $color ada
if (!isset($color)) {
    $color = 'green';
}

// Tentukan inline style berdasarkan warna
$colorStyles = [
    'blue' => 'background: linear-gradient(135deg, #3b82f6, #1d4ed8);',
    'green' => 'background: linear-gradient(135deg, #10b981, #059669);',
    'purple' => 'background: linear-gradient(135deg, #8b5cf6, #7c3aed);',
    'red' => 'background: linear-gradient(135deg, #ef4444, #dc2626);',
    'orange' => 'background: linear-gradient(135deg, #f97316, #ea580c);'
];

// Pastikan ada fallback yang jelas
$cardStyle = array_key_exists($color, $colorStyles) ? $colorStyles[$color] : $colorStyles['green'];
?>

<div class="rounded-lg p-6 text-white border-0 shadow-xl" style="<?= $cardStyle ?>">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-white/80 text-sm font-medium"><?= $title ?></p>
            <p class="text-3xl font-bold"><?= $value ?></p>
            <?php if (!empty($suffix)): ?>
                <p class="text-white/70"><?= $suffix ?></p>
            <?php endif; ?>
            <?php if (!empty($subtext)): ?>
                <p class="text-white/70 text-sm"><?= $subtext ?></p>
            <?php endif; ?>
        </div>
        <div class="bg-white/20 px-5 py-5 rounded-full flex items-center justify-center">
            <i class="<?= $icon ?> text-3xl text-white/95"></i>
        </div>
    </div>
</div>