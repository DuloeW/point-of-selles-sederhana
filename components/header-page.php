<div class="w-full h-16 p-3 pl-5 bg-white flex items-center justify-between shadow-md shadow-gray-200">
    <p class="font-bold text-xl text-purple-700"><?= htmlspecialchars($title) ?></p>
    <div class="text-neutral-600 text-right mr-3">
        <p class="font-bold">Admin: <span><?= getUserDisplayName() ?></span></p>
        <p class="text-xs text-gray-500 font-semibold tracking-wider"><?= getFormattedDate() ?></p>
    </div>
</div>