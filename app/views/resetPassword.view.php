<?php
require_once INCLUDES . 'start.body.php';
require_once INCLUDES . 'header.php';
?>

    <main class="w-full h-fit min-h-dvh">

        <div class="py-20 w-full h-full flex items-center justify-center">

            <form action="" method="post" class="p-10 min-w-96 h-fit bg-gray-200 flex flex-col items-center justify-center gap-10 rounded-lg max-md:w-full max-md:h-full max-sm:p-3 max-md:rounded-none max-md:bg-white">
                <h1 class="font-medium text-center text-2xl text-midnight-sapphire capitalize">reset password</h1>
                <div class="relative w-full flex flex-col flex-none">
                    <label class="text-xl font-thin capitalize" for="password">new password</label>
                    <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="password" name="password" value="<?= \Helpers\FormInputHandler::getPostVariable('password') ?>" id="password">
                    <button class="absolute inset-y-0.4 right-5 top-10" id="eye" type="button">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <div class="relative w-full flex flex-col flex-none">
                    <label class="text-xl font-thin capitalize" for="confirmPassword">Confirm password</label>
                    <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="password" name="confirmPassword" value="<?= \Helpers\FormInputHandler::getPostVariable('confirmPassword') ?>" id="confirmPassword">
                    <button class="absolute inset-y-0.4 right-5 top-10" id="eye" type="button">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <button class="w-full max-sm:w-full h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold" type="submit">send</button>
            </form>

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