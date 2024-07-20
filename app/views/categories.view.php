<?php
require_once INCLUDES . 'start.body.php';
require_once INCLUDES . 'header.php';
?>

    <main class="w-full h-fit min-h-dvh">
        <?php if(isset($data['data']) && count($data['data']) != 0): ?>
        <div class="p-20 w-full flex flex-col gap-10 max-lg:p-10 max-sm:p-3">
            <h2 class="text-5xl font-bold text-cerulean-depths max-md:text-4xl">Find what you want?</h2>
            <div class="flex flex-wrap items-start justify-between gap-20 max-lg:justify-center">
                <?php foreach ($data['data'] as $category): ?>
                    <div class="w-fit h-fit rounded-md">
                        <div class="w-fit h-fit flex gap-8 max-lg:flex-col">
                            <img class="w-96 h-64 object-cover rounded-md max-md:w-80" src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . $category['image_url']) ?>" alt="">
                            <div class="w-96 flex flex-col gap-3 max-lg:items-center justify-between max-md:w-80">
                                <h1 class="text-3xl text-midnight-sapphire"><?= $category['name'] ?></h1>
                                <p class="text-base text-slate-gray"><?= $category['description'] ?></p>
                                <a href="<?= \Helpers\URLHelper::appendToBaseURL('categories/index/' . $category['category_ID']) ?>" class="w-80 h-16 flex gap-3 items-center justify-center bg-cerulean-depths hover:bg-midnight-sapphire duration-150 ease-in-out text-white rounded-md text-xl font-bold capitalize max-sm:w-full">Shop now <i class="fa-solid fa-bag-shopping"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php else: ?>
            <div class="w-full h-full flex flex-col items-center justify-center">
                <p class="text-2xl font-bold text-gray-700">No categories found</p>
                <p class="text-sm text-gray-500 mt-2">Sorry, there are currently no categories available.</p>
            </div>
        <?php endif; ?>
    </main>

<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'footer.php';
require_once INCLUDES . 'end.body.php';
?>