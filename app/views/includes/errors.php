<?php
$icons = [
    'successfully' => 'check',
    'warning' => 'exclamation',
    'error' => 'xmark'
];
$colors = [
    'successfully' => 'turquoise-splash',
    'warning' => 'goldenrod-blaze',
    'error' => 'red'
];
$icon = '';
$color = '';
if(isset($data['errors']['type'])) {
    $icon = $icons[$data['errors']['type']];
    $color = $colors[$data['errors']['type']];
}
if (isset($data['errors']['messages']) && $data['errors']['messages'] > 0): ?>
    <div class="z-40 fixed bottom-0 right-0 p-4 w-96 h-96 flex items-center justify-center bg-white rounded-tl-3xl leading-6 shadow-2xl ring-1 ring-gray-900/5 max-sm:w-80 animate-fadeInUp" id="messages-menu">
        <div class="w-full h-full flex flex-col gap-6">
            <div class="flex flex-row items-center justify-between">
                <div class="w-full h-fit flex flex-row items-center gap-6">
                    <i class="text-<?= $color ?> text-4xl fa-solid fa-circle-<?= $icon ?>"></i>
                    <p class="text-<?= $color ?> text-3xl font-bold tracking-wide capitalize"><?= $data['errors']['type'] ?></p>
                </div>
                <button id="messages-menu-btn">
                    <i class="text-xl text-red fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="flex flex-col gap-3 overflow-y-auto">
                <?php foreach ($data['errors']['messages'] as $message):?>
                    <p class="pl-6 text-lg text-midnight-sapphire"><?= $message ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>