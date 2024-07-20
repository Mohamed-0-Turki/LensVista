<?php
require_once INCLUDES . 'start.body.php';
require_once INCLUDES . 'header.php';
?>

    <main class="w-full h-fit min-h-dvh">
        <?php
        if(isset($data['data']) && count($data['data']) != 0):
            $product = $data['data'];
        ?>
            <div class=" w-full h-fit p-20 flex gap-10 max-sm:p-3 max-xl:flex-col">
                <div class="w-full h-dvh grid grid-rows-5 grid-flow-row gap-5 max-sm:grid-rows-3">

                    <div class="row-span-4 max-sm:row-span-2">
                        <img class="w-full h-full object-contain border-2 border-light-gray hover:border-slate-gray duration-150 ease-in-out cursor-pointer" src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . $product['images'][0]) ?>" alt="" id="main-image">
                    </div>

                    <div class="flex gap-x-3 overflow-x-auto overflow-hidden max-sm:gap-0" id="images-container">
                        <?php foreach ($product['images'] as $imageUrl): ?>
                            <img class="w-full h-full object-contain border-2 border-light-gray hover:border-slate-gray duration-150 ease-in-out cursor-pointer" src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . $imageUrl) ?>" alt="">
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="w-full h-full flex flex-col gap-6 max-sm:gap-3">
                    <div class="w-full flex flex-wrap items-start justify-between gap-6 max-sm:gap-3">
                        <h1 class="font-bold text-6xl truncate max-sm:text-4xl"><?= $product['model'] ?></h1>

                        <?php if (isset($_SESSION['USER']) && $_SESSION['USER']['role'] == 'buyer'): ?>
                            <a href="<?= \Helpers\URLHelper::appendToBaseURL('wishlist/addToWishlist/') . $product['frame_ID'] ?>" class="w-16 h-16 flex items-center justify-center border border-light-gray hover:border-slate-gray duration-150 ease-in-out rounded-md max-sm:w-8 max-sm:h-8">
                                <span class="text-3xl text-red max-sm:text-xl">
                                    <?php if ($product['is_wishlisted'] == 0): ?>
                                        <i class="fa-regular fa-heart"></i>
                                    <?php else: ?>
                                        <i class="fa-solid fa-heart"></i>
                                    <?php endif; ?>
                                </span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION['USER']) && $_SESSION['USER']['role'] == 'buyer'): ?>
                        <div class="flex flex-row gap-3 text-goldenrod-blaze text-2xl">
                            <a href="<?= \Helpers\URLHelper::appendToBaseURL('products/rateProduct/') . $product['frame_ID'] . '/1' ?>"><i class="fa-<?= ($product['rate'] >= 1) ? 'solid': 'regular' ?> fa-star"></i></a>
                            <a href="<?= \Helpers\URLHelper::appendToBaseURL('products/rateProduct/') . $product['frame_ID'] . '/2' ?>"><i class="fa-<?= ($product['rate'] >= 2) ? 'solid': 'regular' ?> fa-star"></i></a>
                            <a href="<?= \Helpers\URLHelper::appendToBaseURL('products/rateProduct/') . $product['frame_ID'] . '/3' ?>"><i class="fa-<?= ($product['rate'] >= 3) ? 'solid': 'regular' ?> fa-star"></i></a>
                            <a href="<?= \Helpers\URLHelper::appendToBaseURL('products/rateProduct/') . $product['frame_ID'] . '/4' ?>"><i class="fa-<?= ($product['rate'] >= 4) ? 'solid': 'regular' ?> fa-star"></i></a>
                            <a href="<?= \Helpers\URLHelper::appendToBaseURL('products/rateProduct/') . $product['frame_ID'] . '/5' ?>"><i class="fa-<?= ($product['rate'] == 5) ? 'solid': 'regular' ?> fa-star"></i></a>
                        </div>
                    <?php endif; ?>

                    <div class="flex flex-row items-center gap-3 text-xl">
                        <i class="text-goldenrod-blaze fa-regular fa-star-half-stroke"></i>
                        <p class=" capitalize">rate: <?= $product['averageRate'] ?></p>
                    </div>

                    <div>
                        <h2 class="font-bold text-5xl max-sm:text-4xl">
                            <span class="text-turquoise-splash"><?= $product['price'] ?></span>
                            <span class="uppercase ml-1">egp</span>
                        </h2>
                    </div>

                    <p class="text-2xl text-balance max-sm:text-xl"><?= $product['description'] ?></p>

                    <p class="font-bold text-xl uppercase text-cerulean-depths">Gender: <span class="text-black font-medium capitalize"><?= $product['gender'] ?></span></p>

                    <p class="font-bold text-xl uppercase text-cerulean-depths">Frame Material: <span class="text-black font-medium capitalize"><?= $product['frame_material'] ?></span></p>

                    <p class="font-bold text-xl uppercase text-cerulean-depths">Frame Style: <span class="text-black font-medium capitalize"><?= $product['frame_style'] ?></span></p>

                    <p class="font-bold text-xl uppercase text-cerulean-depths">Frame Shape: <span class="text-black font-medium capitalize"><?= $product['frame_shape'] ?></span></p>

                    <p class="font-bold text-xl uppercase text-cerulean-depths">Nose Pads: <span class="text-black font-medium capitalize"><?= $product['frame_nose_pads'] ?></span></p>

                    <div class="flex flex-col gap-y-3">
                        <p class="font-bold text-xl uppercase text-cerulean-depths">colors:</p>
                        <div class="w-fit h-fit flex flex-wrap gap-3">
                            <?php foreach ($product['colors'] as $color): ?>
                                <a href="?frameColor=<?= trim($color, "#") ?>" id="color-option" class="w-12 h-12 rounded-full border-light-gray" style="background-color: <?= $color ?>"></a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php if (isset($product['options'])): ?>
                        <div class="flex flex-col gap-y-3">
                            <p class="font-bold text-xl capitalize text-cerulean-depths">frame size:</p>
                            <div class="w-fit h-fit flex flex-wrap gap-3">
                                <?php foreach ($product['options'] as $option): ?>
                                    <a id="size-link" href="?frameColor=<?= $_GET['frameColor'] ?>&frameOptionID=<?= $option['frameOption_ID'] ?>" class="min-w-80 min-h-12 flex items-center justify-center text-xl border-2 <?= (isset($_GET['frameOptionID']) && $_GET['frameOptionID'] == $option['frameOption_ID']) ? 'border-slate-gray' : 'border-light-gray' ?>  hover:border-slate-gray duration-150 ease-in-out rounded-md cursor-pointer">
                                        <?= $option['frame_width'] ?>mm, <?= $option['bridge_width'] ?>mm, <?= $option['temple_length'] ?>mm
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="border-2 w-full h-12 flex items-center justify-center rounded-lg max-md:h-14 max-md:p-2">
                            <p class="text-xl text-gray-800 text-center max-md:text-lg max-sm:text-base">Select a color to view all available sizes for that color</p>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['USER'])): if ($_SESSION['USER']['role'] == 'buyer'): ?>
                        <form action="" method="post" class="flex flex-col gap-6">
                            <input class="hidden" type="text" value="<?= $product['frame_ID'] ?>" name="frameID">
                            <input class="hidden" type="text" value="<?= $_GET['frameOptionID'] ?? '' ?>" name="frameOptionID" id="frameOptionID">
                            <div class="flex flex-col gap-y-3">
                                <p id="quantity-text" class="font-bold text-xl uppercase text-cerulean-depths">Quantity: <span class="text-black">1</span></p>
                                <div class="w-28 h-12 flex items-center justify-evenly border-2 border-light-gray rounded-md">
                                    <button type="button" id="btn-minus" class="font-bold cursor-pointer"><i class="fa-solid fa-minus"></i></button>
                                    <input id="quantity-input" class="w-1/2 h-full text-center focus:outline-none text-lg" type="text" value="1" name="frameQuantity">
                                    <button type="button" id="btn-plus" class="font-bold cursor-pointer"><i class="fa-solid fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="w-full max-sm:flex max-sm:items-center max-sm:justify-center">
                                <button class="w-80 h-16 font-blod bg-cerulean-depths hover:bg-midnight-sapphire duration-150 ease-in-out text-white rounded-md text-xl font-bold capitalize max-sm:w-full" type="submit">add to cart <i class="fa-solid fa-cart-shopping"></i></button>
                            </div>
                        </form>
                    <?php endif; else: ?>
                        <a href="<?= \Helpers\URLHelper::appendToBaseURL('login') ?>" class="w-full h-16 flex items-center justify-center font-blod bg-cerulean-depths hover:bg-midnight-sapphire duration-150 ease-in-out text-white rounded-md text-xl max-md:text-base font-bold capitalize text-center" type="submit">
                            Please log in to your account to add items to your cart.
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="pb-20 px-20 max-sm:px-3 max-sm:pb-3 flex flex-col gap-5 ">
                <h1 class="text-2xl font-bold">Comments</h1>
                <?php if(isset($_SESSION['USER']) && $_SESSION['USER']['role'] == 'buyer'): ?>
                    <form action="<?= \Helpers\URLHelper::appendToBaseURL('products/sendComment/') . $product['frame_ID'] ?>" method="post" class="flex flex-col gap-3">
                        <textarea name="comment" id="" class="w-96 h-20 appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-150" placeholder="Enter your comment here"></textarea>
                        <button type="submit" class="w-20 h-8 text-white font-bold bg-turquoise-splash hove:bg-emerald-envy rounded">send</button>
                    </form>
                <?php endif; ?>
                <?php foreach($product['comments'] as $comment): ?>
                <div class="p-3 w-96 bg-gray-200 rounded">
                    <div class="flex flex-col gap-">
                        <p class="text-base text-black"><i class="fa-solid fa-user"></i> <?= $comment['first_name'] . ' ' . $comment['last_name'] ?></p>
                        <p class="text-sm text-black ml-2"><?= $comment['comment'] ?></p>
                        <?php if(isset($_SESSION['USER']) && (($_SESSION['USER']['role'] == 'buyer' && $_SESSION['USER']['userID'] == $comment['user_ID']) || ($_SESSION['USER']['role'] == 'admin'))): ?>
                            <div class="relative mt-10">
                                <a href="<?= \Helpers\URLHelper::appendToBaseURL('comments/deleteComment/') . $comment['comment_ID'] ?>" class="absolute bottom-0 right-0 rounded w-20 h-8 flex items-center justify-center text-white font-bold bg-red hover:bg-solid-red ease-in-out duration-150">delete</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="w-full h-full flex flex-col items-center justify-center">
                <p class="text-2xl font-bold text-gray-700">No product found</p>
                <p class="text-sm text-gray-500 mt-2">Sorry, there is currently this product not available.</p>
            </div>
        <?php endif; ?>
    </main>

    <script>
        const mainImage = document.querySelector("#main-image")
        const allImages = Array.from(document.querySelectorAll("#images-container img"))
        setImageOnClick(mainImage, allImages)
        cycleImages(mainImage, allImages)


        const minusBtn = document.querySelector("#btn-minus");
        const plusBtn = document.querySelector("#btn-plus");
        const quantityInput = document.querySelector("#quantity-input");
        const quantityText = document.querySelector("#quantity-text span");

        if (quantityInput !== null) {
            initializeQuantityControls(minusBtn, plusBtn, quantityInput, quantityText);
        }

        const frameOptions = Array.from(document.querySelectorAll("#size-link"))
        const frameOptionInput = document.querySelector("#frameOptionID");

        frameOptions.forEach(option => {
            option.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent the default link behavior

                // Remove 'border-slate-gray' from all options and add 'border-light-gray'
                frameOptions.forEach(l => {
                    l.classList.remove('border-slate-gray');
                    l.classList.add('border-light-gray');
                });

                // Add 'border-slate-gray' to the clicked option
                option.classList.remove('border-light-gray');
                option.classList.add('border-slate-gray');
            });
        });

        frameOptions.forEach(option => {
            option.addEventListener('click', function(event) {
                event.preventDefault();
                const newUrl = new URL(option.href);
                const params = new URLSearchParams(newUrl.search);
                const frameOptionID = params.get('frameOptionID');
                frameOptionInput.value = frameOptionID;
                frameOptionInput.setAttribute('value', frameOptionID);
                history.pushState(null, '', newUrl);
            });
        })
    </script>

<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'footer.php';
require_once INCLUDES . 'end.body.php';
?>