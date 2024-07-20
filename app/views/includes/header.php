<?php
$dropDownUserMenuContent = [
    'profile'   => [
        'link' => \Helpers\URLHelper::appendToBaseURL('session/profile/' . (isset($_SESSION['USER']) ? $_SESSION['USER']['userID'] : '')),
        'icon' => 'user'
    ],
    'dashboard' => [
        'link' => \Helpers\URLHelper::appendToBaseURL('dashboard'),
        'icon' => 'chart-line'
    ],
    'my orders' => [
        'link' => \Helpers\URLHelper::appendToBaseURL('orders/index/' . (isset($_SESSION['USER']) ? $_SESSION['USER']['userID'] : '')),
        'icon' => 'border-top-left'
    ],
    'login'     => [
        'link' => \Helpers\URLHelper::appendToBaseURL('login'),
        'icon' => 'door-open'
    ],
    'sign up'   => [
        'link' => \Helpers\URLHelper::appendToBaseURL('signup'),
        'icon' => 'user-plus'
    ],
    'logout'    => [
        'link' => \Helpers\URLHelper::appendToBaseURL('session/logout'),
        'icon' => 'person-running'
    ]
];
$navbarMenuContent = [
    'home' => [
        'link' => \Helpers\URLHelper::appendToBaseURL(),
        'icon' => 'house'
    ],
    'categories' => [
        'link' => \Helpers\URLHelper::appendToBaseURL('categories'),
        'icon' => 'table-list'
    ],
    'about us' => [
        'link' => \Helpers\URLHelper::appendToBaseURL('home#aboutUs'),
        'icon' => 'address-card'
    ],
    'contact us' => [
        'link' => \Helpers\URLHelper::appendToBaseURL('home#contactUs'),
        'icon' => 'file-contract'
    ]
];
?>

<!-- Header & Nav -->
<header class="w-full flex flex-col items-center">
    <!-- Start Header -->
    <div class="w-11/12 h-28 flex flex-row flex-wrap items-center justify-between max-lg:h-36">
        <!-- Website name -->
        <a href="<?= \Helpers\URLHelper::appendToBaseURL() ?>" class="font-extrabold text-4xl max-sm:text-3xl">
            <i class="text-goldenrod-blaze fa-solid fa-glasses"></i>
            <span class="text-midnight-sapphire tracking-wide capitalize">lensVista</span>
        </a>
        <!-- Search -->
        <form action="<?= \Helpers\URLHelper::appendToBaseURL('products') ?>" method="GET" class="relative group w-2/4 h-12 max-lg:w-full flex flex-col gap-5 max-lg:order-last">
            <div class="relative group w-full h-full flex flex-row text-2xl border rounded-full hover:border-cerulean-depths ease-in-out duration-150">
                <input class="w-full h-full outline-0 rounded-full pl-4 focus:ring-1 focus:ring-midnight-sapphire ease-in-out duration-150 max-lg:w-full" type="text" name="search" id="search-input">
                <button class="absolute inset-y-0 right-5 h-full text-midnight-sapphire group-hover:text-sunburst-gold ease-in-out duration-150" type="button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
            <div class="hidden z-30 absolute w-full max-h-96 top-16 bg-white overflow-y-scroll rounded-3xl leading-6 shadow-2xl ring-1 ring-gray-900/5" id="search-results-container">
                <ul class="flex flex-col gap-5 text-midnight-sapphire p-4" id="search-results">
                </ul>
            </div>
        </form>

        <!-- Cart & Profile -->
        <div class="relative w-fit flex flex-row items-center justify-end gap-x-8 max-sm:gap-x-4">
            <!-- Cart -->
            <?php if (isset($_SESSION['USER']) && $_SESSION['USER']['role'] === 'buyer'): ?>
                <a class="relative group w-12 h-12 flex items-end justify-center max-sm:w-10 max-sm:h-10" href="<?= \Helpers\URLHelper::appendToBaseURL('cart') ?>">
                    <p id="cart-quantity" class="absolute -right-1 -top-1 w-7 h-7 font-semibold text-center rounded-full text-midnight-sapphire group-hover:text-white bg-sunburst-gold group-hover:bg-goldenrod-blaze max-sm:w-6 max-sm:h-6 max-sm:-top-2 ease-in-out duration-150">0</p>
                    <i class="text-4xl text-midnight-sapphire group-hover:text-black ease-in-out duration-150 fa-solid fa-cart-shopping"></i>
                </a>
            <?php endif; ?>
            <!-- Btn To Show User drop-down menu -->
            <button class="overflow-hidden w-12 h-12 text-2xl border-0 rounded-full text-white bg-sunburst-gold hover:bg-goldenrod-blaze ease-in-out duration-150 max-sm:w-10 max-sm:h-10" id="user-menu-btn">
                <i class="fa-solid fa-user"></i>
            </button>

            <!-- Start User drop-down menu -->
            <div class="z-40 hidden absolute w-80 top-16 right-0 bg-white overflow-hidden rounded-3xl leading-6 shadow-2xl ring-1 ring-gray-900/5 animate-fadeOn" id="user-menu">
                <ul class="flex flex-col text-2xl text-midnight-sapphire p-4">
                    <?php
                        if (isset($_SESSION['USER'])) {
                            unset($dropDownUserMenuContent['login']);
                            unset($dropDownUserMenuContent['sign up']);
                            if ($_SESSION['USER']['role'] === 'buyer') {
                                $dropDownMenuContent['profile']['link'] = $_SESSION['USER']['userID'];
                                unset($dropDownUserMenuContent['dashboard']);
                            } if ($_SESSION['USER']['role'] === 'admin') {
                                unset($dropDownUserMenuContent['my orders']);
                                unset($dropDownUserMenuContent['profile']);
                            }
                        }
                        else {
                            unset($dropDownUserMenuContent['profile']);
                            unset($dropDownUserMenuContent['dashboard']);
                            unset($dropDownUserMenuContent['my orders']);
                            unset($dropDownUserMenuContent['logout']);
                        }
                        foreach ($dropDownUserMenuContent as $name => $item):
                            $link = $item['link'];
                            $icon = $item['icon'];
                            echo <<<"dropDown"
                                <li class="group w-full h-20 rounded-3xl hover:bg-light-gray ease-in-out duration-150">
                                    <a class="group-hover:text-cerulean-depths h-full flex flex-row items-center justify-around" href="$link">
                                        <p class="capitalize">$name</p>
                                        <i class="fa-solid fa-$icon"></i>
                                    </a>
                                </li>
                            dropDown;
                        endforeach;
                    ?>
                </ul>
            </div>
            <!-- End User drop-down menu -->
        </div>
        <!-- End Cart & Profile -->
    </div>
    <!-- End Header -->

    <!-- Start Nav -->
    <nav class="relative w-full h-16 bg-midnight-sapphire flex items-center justify-evenly">

        <!-- Website Logo -->
        <a href="<?= \Helpers\URLHelper::appendToBaseURL() ?>" class="text-4xl text-sunburst-gold hover:text-goldenrod-blaze ease-in-out duration-150 max-sm:w-4/6">
            <i class="fa-solid fa-glasses"></i>
        </a>

        <!-- Btn To Show Nav -->
        <button class="hidden justify-between order-last max-sm:flex" id="navbar-menu-btn">
            <i class="text-white fa-solid fa-bars text-3xl"></i>
        </button>

        <!-- Start Menu -->
        <ul class="w-5/6 h-full flex flex-row justify-around text-white max-sm:hidden">
            <?php
                foreach ($navbarMenuContent as $name => $item):
                    $link = $item['link'];
                    echo <<<"menu"
                        <li class="px-3 w-fit h-full text-2xl hover:text-sky-breeze-blue ease-in-out duration-150">
                            <a class="h-full flex items-center justify-center" href="$link">$name</a>
                        </li>
                    menu;
                endforeach;
            ?>
        </ul>
        <!-- End Menu -->

        <?php if (isset($_SESSION['USER']) && $_SESSION['USER']['role'] === 'buyer'): ?>
            <a href="<?= \Helpers\URLHelper::appendToBaseURL('wishlist') ?>" class="text-4xl text-white hover:text-red ease-in-out duration-150">
                <i class="fa-solid fa-heart"></i>
            </a>
        <?php endif; ?>
    </nav>
    <!-- End Nav -->
</header>
<!-- End Header & Nav -->

<div class="hidden z-50 absolute right-0 w-80 h-fit bg-midnight-sapphire rounded-bl-3xl shadow-2xl ring-1 ring-gray-900/5 animate-fadeOn" id="navbar-menu">
    <ul class="flex flex-col text-2xl text-light-gray p-4">
        <?php
        foreach ($navbarMenuContent as $name => $item):
            $link = $item['link'];
            $icon = $item['icon'];
            echo <<<"menu"
                 <li class="group w-full h-20 rounded-3xl hover:bg-cerulean-depths ease-in-out duration-150 animate-fadeInRight">
                     <a class="group-hover:text-white h-full px-5 flex flex-row items-center justify-between" href="$link">
                        <p class="capitalize">$name</p>
                        <i class="fa-solid fa-$icon"></i>
                    </a>
                </li>
             menu;
        endforeach;
        ?>
    </ul>
</div>