<?php
require_once INCLUDES . 'start.body.php';
require_once INCLUDES . 'header.php';
?>

<main class="w-full h-fit min-h-dvh">

    <div class="p-20 grid grid-cols-2 items-center justify-between max-xl:grid-cols-1 max-xl:justify-items-center max-sm:p-3">
        <form action="" method="POST" class="h-fit flex flex-col items-start justify-between gap-4 max-sm:w-full max-xl:justify-center">
            <h1 class="text-6xl font-bold text-cerulean-depths tracking-wider capitalize max-sm:text-xl">
                welcome back !
            </h1>
            <p class="text-3xl font-bold capitalize max-sm:text-2xl">
                Sign in to your Account
            </p>
            <div class="w-full flex flex-col gap-8">

                <!-- Email -->
                <div class="w-96 flex flex-col flex-none max-xl:w-full">
                    <label class="text-xl font-thin capitalize" for="email">email</label>
                    <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="email" name="email" value="<?= \Helpers\FormInputHandler::getPostVariable('email') ?>" id="email" placeholder="example@ex.com">
                </div>

                <!-- Password -->
                <div class="relative w-96 flex flex-col flex-none max-xl:w-full">
                    <label class="text-xl font-thin capitalize" for="password">password</label>
                    <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="password" name="password" value="<?= \Helpers\FormInputHandler::getPostVariable('password') ?>" id="password">
                    <button class="absolute inset-y-0.4 right-5 top-10" id="eye" type="button"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>

            <!-- Link Forgot Password -->
            <a class="underline capitalize text-blue visited:text-purple" href="<?= \Helpers\URLHelper::appendToBaseURL('forgotPassword/checkEmail') ?>">forgot password ?</a>

            <!-- Check Box Remember Me -->
            <div class="flex flex-row items-center gap-4">
                <input class="h-5 w-5 text-midnight-sapphire focus:ring-slate-gray border-gray-300 rounded-md" type="checkbox" name="rememberMe" value="on" id="rememberMe" <?= \Helpers\FormInputHandler::getCheckedStatus('rememberMe', 'on') ?>>
                <label class="capitalize" for="rememberMe">
                    remember me
                </label>
            </div>

            <!-- Submit Btn -->
            <button class="w-48 h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold" type="submit">log in</button>

            <!-- Link Sign up -->
            <p class="capitalize sm:tracking-widest">
                Don’t have an Account?
                <a class="underline text-blue visited:text-purple" href="<?= \Helpers\URLHelper::appendToBaseURL('signup') ?>">Register Now</a>
            </p>
        </form>
        <!-- End Login -->

        <!-- Image In Login -->
        <img class="w-full rounded-lg shadow-2xl object-cover max-xl:hidden" src="<?= \Helpers\URLHelper::appendToBaseURL('public/assets/images/people-with-glasses-composition.jpg') ?>" alt="" srcset="">
    </div>

</main>
    <script>
        const btnEyes = Array.from(document.querySelectorAll("#eye"));
        const passwords = Array.from(document.querySelectorAll('[type="password"]'));
        showPassword(btnEyes, passwords)
    </script>
<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'footer.php';
require_once INCLUDES . 'end.body.php';
?>