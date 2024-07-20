<?php
    require_once INCLUDES . 'start.body.php';
    require_once INCLUDES . 'header.php';
?>

    <main class="w-full h-fit min-h-dvh">
        <div class="w-full flex flex-col items-center justify-center gap-0">
            <div class=" relative isolate w-full h-dvh overflow-hidden bg-black" id="home">
                <img class="absolute inset-0 -z-10 h-full w-full object-cover opacity-50" src="<?= \Helpers\URLHelper::appendToBaseURL('public/assets/images/closeup-view-beach-viewed-from-lenses-black-glasses.jpg') ?>" alt="">
                <div class="w-full h-full flex flex-col items-center justify-center gap-10">
                    <h1 class="font-bold text-8xl text-goldenrod-blaze max-lg:text-6xl text-center text-balance ">welcome in lensVista</h1>
                    <p class="px-3 max-w-[700px] h-fit text-center text-2xl max-lg:text-lg max-md:text-base text-white">
                        Welcome to LensVista, your go-to destination for stylish and affordable eyeglass frames. Our mission is to make high-quality eyewear accessible to everyone, combining fashion, comfort, and functionality in every pair.
                    </p>
                    <div class="flex flex-row items-center gap-5 max-md:flex-col">
                        <?php if (! (isset($_SESSION['USER']))): ?>
                            <a href="<?= \Helpers\URLHelper::appendToBaseURL('login') ?>" class="w-48 h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold flex items-center justify-center" type="submit">login</a>
                            <p class="w-10 h-10 bg-white rounded-full text-black flex items-center justify-center">or</p>
                            <a href="<?= \Helpers\URLHelper::appendToBaseURL('signup') ?>" class="w-48 h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold flex items-center justify-center" type="submit">sign up</a>
                        <?php else:?>
                            <a href="<?= \Helpers\URLHelper::appendToBaseURL('products') ?>" class="w-48 h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold flex items-center justify-center gap-3" type="submit"><span>shopping now</span><i class="fa-solid fa-chevron-right"></i></a>
                        <?php endif;?>
                    </div>
                </div>
            </div>

            <div class=" py-10 w-full h-fit flex flex-col gap-5 items-center justify-center" id="aboutUs">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">About us</h2>
                <div class="h-fit row-span-1 p-10 grid grid-cols-2 gap-10 max-sm:p-3 max-xl:grid-cols-1">
                    <div class="col-span-1 flex flex-col gap-3">
                        <p class="text-2xl font-bold text-midnight-sapphire">Who We Are?</p>
                        <p class="text-lg leading-6 text-gray-600 text-balance">At LensVista, we are passionate about eyewear. Our team of experienced opticians and fashion experts collaborates to curate a diverse collection of eyeglass frames that cater to all tastes and preferences. From classic designs to the latest trends, we ensure that you find the perfect pair to complement your style and enhance your vision.</p>
                    </div>
                    <div class="col-span-1 flex flex-col gap-3">
                        <p class="text-2xl font-bold text-midnight-sapphire">Our Commitment</p>
                        <p class="text-lg leading-6 text-gray-600 text-balance">Quality and customer satisfaction are at the heart of everything we do. We meticulously select materials and employ rigorous quality control processes to guarantee that every frame meets our high standards. Our user-friendly website, secure payment options, and efficient delivery services ensure a seamless shopping experience from start to finish.</p>
                    </div>
                    <div class="col-span-1 flex flex-col gap-3">
                        <p class="text-2xl font-bold text-midnight-sapphire">Why Choose LensVista?</p>
                        <ol class="list-decimal">
                            <li class="text-lg leading-6 text-gray-600 text-balance">
                                Extensive Selection: Explore a wide range of frames for men, women, and children, including prescription glasses, sunglasses, and blue light blocking lenses.
                            </li>
                            <li class="text-lg leading-6 text-gray-600 text-balance">
                                Affordable Prices: Enjoy competitive prices without compromising on quality. We believe that everyone deserves access to premium eyewear.
                            </li>
                            <li class="text-lg leading-6 text-gray-600 text-balance">
                                Customer-Centric Approach: Our dedicated customer service team is here to assist you with any questions or concerns, ensuring you have a pleasant and satisfying shopping experience.
                            </li>
                            <li class="text-lg leading-6 text-gray-600 text-balance">
                                Sustainability: We are committed to sustainable practices and offer eco-friendly frame options to reduce our environmental footprint.            </li>
                        </ol>
                    </div>

                    <div class="col-span-1 flex flex-col gap-3">
                        <p class="text-2xl font-bold text-midnight-sapphire">Join the LensVista Family</p>
                        <p class="text-lg leading-6 text-gray-600 text-balance">At LensVista, we are more than just an eyewear retailer – we are a community. Follow us on social media to stay updated on the latest styles, special promotions, and eye care tips. Join our newsletter for exclusive offers and insights into the world of eyewear.</p>
                    </div>
                </div>
            </div>

            <div class=" py-10 w-full h-fit flex flex-col gap-5 items-center justify-center bg-light-gray" id="contactUs">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Contact us</h2>
                <form action="<?= \Helpers\URLHelper::appendToBaseURL('feedback/sendFeedback') ?>" method="post" class="px-3 grid grid-cols-2 gap-5 max-md:w-full">
                    <div class="col-span-1 max-md:col-span-2 flex flex-col flex-none max-xl:w-full">
                        <label class="text-xl font-thin capitalize" for="firstName">First Name</label>
                        <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="firstName" value="<?= \Helpers\FormInputHandler::getPostVariable('firstName') ?>" id="firstName" placeholder="John">
                    </div>

                    <div class="col-span-1 max-md:col-span-2 flex flex-col flex-none max-xl:w-full">
                        <label class="text-xl font-thin capitalize" for="lastName">Last Name</label>
                        <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="lastName" value="<?= \Helpers\FormInputHandler::getPostVariable('lastName') ?>" id="lastName" placeholder="Robert">
                    </div>

                    <!-- Email -->
                    <div class="col-span-2 flex flex-col flex-none max-xl:w-full">
                        <label class="text-xl font-thin capitalize" for="email">email</label>
                        <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="email" name="email" value="<?= \Helpers\FormInputHandler::getPostVariable('email') ?>" id="email" placeholder="ex@example.com" autocomplete="off">
                    </div>

                    <!-- phone number -->
                    <div class="col-span-2 flex flex-col flex-none max-xl:w-full">
                        <label class="text-xl font-thin capitalize" for="phoneNumber">phone number</label>
                        <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="phoneNumber" value="<?= \Helpers\FormInputHandler::getPostVariable('phoneNumber') ?>" id="phoneNumber" placeholder="+20 xxx xxx xx xx">
                    </div>

                    <div class="col-span-2 row-span-3 flex flex-col flex-none max-xl:w-full">
                        <label class="text-xl font-thin capitalize" for="message">message</label>
                        <textarea class="focus:border-cerulean-depths outline-none h-40 border-2 rounded-md px-3 ease-in-out duration-150" name="message" id="message"><?= \Helpers\FormInputHandler::getPostVariable('message') ?></textarea>
                    </div>

                    <button class="col-span-2 h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold" type="submit">let's talk</button>

                </form>
            </div>
        </div>
    </main>

<?php
    require_once INCLUDES . 'elements.php';
    require_once INCLUDES . 'errors.php';
    require_once INCLUDES . 'footer.php';
    require_once INCLUDES . 'end.body.php';
?>