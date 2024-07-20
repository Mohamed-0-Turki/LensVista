<?php
require_once INCLUDES . 'start.body.php';
require_once INCLUDES . 'header.php';
?>

    <main class="w-full h-fit min-h-dvh">
        <div class="relative w-full flex flex-row">
            <?php if(isset($data['data']) && count($data['data']) != 0): ?>
                <div class="p-20 w-full h-fit flex flex-row flex-wrap items-center justify-center gap-10 max-sm:p-3">
                    <?php foreach ($data['data'] as $product): ?>
                        <a href="<?= \Helpers\URLHelper::appendToBaseURL('products/index/') . $product['frame_ID'] ?>" class="w-72 h-96 border-1 overflow-hidden bg-white shadow-md rounded-xl duration-150 hover:scale-105 hover:shadow-xl">
                        <img class="w-72 h-1/2 object-cover" src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . $product['image_url']) ?>" alt="" srcset="">
                        <!-- Product Details -->
                        <div class="p-5 flex flex-col gap-4">
                            <!-- Model Name -->
                            <p class="text-2xl font-black tracking-wide capitalize truncate text-midnightSapphire"><?= $product['model'] ?></p>
                            <!-- colors -->
                            <div class="flex flex-row gap-2">
                                <?php foreach ($product['colors'] as $color): ?>
                                    <div class="w-3 h-3 rounded-full" style="background-color: <?= $color ?>"></div>
                                <?php endforeach; ?>
                            </div>
                            <!-- Price -->
                            <div class="flex items-center justify-between">
                                <p class="font-bold text-midnightSapphire">
                                    <span class="text-xl"><?= $product['price'] ?></span>
                                    <span class="text-lg uppercase ml-1">egp</span>
                                </p>
                                <i class="fa-solid fa-bag-shopping"></i>
                            </div>
                            <!-- Product Status -->
                            <div class="flex items-center gap-2">
                                <?php
                                    $statusColor = ($product['status'] == 1) ? '#0ca678' : '#ff0000';
                                    $statusText = ($product['status'] == 1) ? 'in' : 'out';
                                ?>
                                <div class="w-2 h-2 rounded-full" style="background-color: <?= $statusColor ?>"></div>
                                <p class="text-md font-medium capitalize"  style="color: <?= $statusColor ?>"><?= $statusText ?> Stock</p>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if(isset($data['data']) && count($data['data']) == 0): ?>
            <div class="w-full h-full flex flex-col items-center justify-center">
                <p class="text-2xl font-bold text-gray-700">No products found</p>
                <p class="text-sm text-gray-500 mt-2">Sorry, there are currently no products available.</p>
            </div>
        <?php endif; ?>
    </main>

    <script>
    </script>

<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'footer.php';
require_once INCLUDES . 'end.body.php';
?>