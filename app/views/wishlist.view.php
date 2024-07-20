<?php
require_once INCLUDES . 'start.body.php';
require_once INCLUDES . 'header.php';
?>

    <main class="w-full h-fit min-h-dvh">
        <div class="p-20 flex flex-col gap-10 max-sm:p-3">
            <h1 class="text-6xl font-bold text-cerulean-depths tracking-wider capitalize max-sm:text-3xl">my wishlist</h1>
            <?php if(isset($data['data']) && count($data['data']) != 0): ?>
                <div class=" h-fit flex flex-row flex-wrap items-center justify-center gap-10 ">
                    <?php foreach ($data['data'] as $wish): ?>
                        <div class="w-72 h-fit border-1 overflow-hidden bg-white shadow-md rounded-xl duration-150 hover:scale-105 hover:shadow-xl">
                            <img class="w-72 h-64 object-cover" src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . $wish['image_url']) ?>" alt="">
                            <div class="p-5 h-full flex flex-col items-center gap-2">
                                <p class="text-2xl font-black tracking-wide capitalize truncate text-midnightSapphire"><?= $wish['model'] ?></p>
                                <div class="w-full flex flex-col">
                                    <div class="flex items-center justify-between">
                                        <p class="font-bold text-midnightSapphire text-lg uppercase text-cerulean-depths mr-1">price:
                                            <span class="text-black font-medium"><?= $wish['price'] ?><span class="text-base uppercase ml-1">egp</span></span>
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <p class="font-bold text-midnightSapphire text-lg uppercase text-cerulean-depths mr-1">Frame Material:
                                            <span class="text-black font-medium"><?= $wish['frame_material'] ?></span>
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <p class="font-bold text-midnightSapphire text-lg uppercase text-cerulean-depths mr-1">Frame Style:
                                            <span class="text-black font-medium"><?= $wish['frame_style'] ?></span>
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <p class="font-bold text-midnightSapphire text-lg uppercase text-cerulean-depths mr-1">Frame Shape:
                                            <span class="text-black font-medium"><?= $wish['frame_shape'] ?></span>
                                        </p>
                                    </div>
                                </div>
                                <!-- Details link -->
                                <a href="<?= \Helpers\URLHelper::appendToBaseURL('products/index/') . $wish['frame_ID'] ?>" class="w-full h-10 flex items-center justify-center bg-cerulean-depths hover:bg-midnight-sapphire text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">details</a>
                                <!-- Delete link -->
                                <a href="<?= \Helpers\URLHelper::appendToBaseURL('wishlist/addToWishlist/') . $wish['frame_ID'] ?>" class="w-full h-10 flex items-center justify-center bg-red hover:bg-solid-red text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">delete</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if(isset($data['data']) && count($data['data']) == 0): ?>
            <div class="w-full h-full flex flex-col items-center justify-center">
                <p class="text-2xl font-bold text-gray-700">Empty Wishlist</p>
                <p class="text-sm text-gray-500 mt-2">Unfortunately, this product is currently not available.</p>
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