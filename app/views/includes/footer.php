<footer class="pt-10 flex flex-col gap-5 items-center justify-center bg-midnight-sapphire">
    <div class="flex flex-col gap-5 items-center justify-center">
        <a href="#" class="font-extrabold tracking-wide text-4xl first-letter:text-6xl capitalize text-white first-letter:text-sunburst-gold max-sm:text:xl">LensVista</a>
        <p class="w-1/2 text-xl text-center text-white max-sm:text-base max-lg:w-full">
            Welcome to LensVista, your go-to destination for stylish and affordable eyeglass frames. Our mission is to make high-quality eyewear accessible to everyone, combining fashion, comfort, and functionality in every pair.
        </p>
        <ul class="flex flex-nonwrap gap-10 max-sm:gap-3 max-sm:flex-col max-sm:items-center">
            <?php
            if (isset($navbarMenuContent)):
                foreach ($navbarMenuContent as $name => $item):
                    $link = $item['link'];
                    echo <<<"menu"
                        <li class="text-2xl text-white hover:text-cerulean-depths capitalize duration-150 ease-in-out"><a href="$link">$name</a></li>
                    menu;
                endforeach;
            endif;
            ?>
        </ul>
        <ul class="flex flex-nonwrap gap-10 max-sm:gap-3 max-sm:flex-col max-sm:items-center">
            <li class="text-2xl text-white hover:text-cerulean-depths capitalize duration-150 ease-in-out"><a href="#"><i class="fa-brands fa-square-facebook"></i></a></li>
            <li class="text-2xl text-white hover:text-cerulean-depths capitalize duration-150 ease-in-out"><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
            <li class="text-2xl text-white hover:text-cerulean-depths capitalize duration-150 ease-in-out"><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
            <li class="text-2xl text-white hover:text-cerulean-depths capitalize duration-150 ease-in-out"><a href="#"><i class="fa-brands fa-github"></i></a></li>
        </ul>
    </div>
    <div class="w-full h-10 flex items-center justify-center bg-cerulean-depths">
        <p class="text-base text-white">Created By Turki | &#xA9; 2023 All Rights Reserved.</p>
    </div>
</footer>