<?php
require_once INCLUDES . 'start.body.php';
require_once INCLUDES . 'header.php';
?>

    <main class="w-full h-fit min-h-dvh">

        <div class="py-20 w-full h-full flex items-center justify-center">
            <form action="" method="post" class="p-10 min-w-96 h-fit bg-gray-200 flex flex-col items-center justify-center gap-10 rounded-lg max-md:w-full max-md:h-full max-sm:p-3 max-md:rounded-none max-md:bg-white">
                <h1 class="font-medium text-center text-2xl text-midnight-sapphire capitalize">verification code</h1>
                <p class="text-black text-base capitalize">Enter the verification code that you received via email: <span class="font-bold normal-case"><?= (isset($_GET['email'])) ? $_GET['email'] : 'example@ex.com'; ?></span></p>
                <label class="hidden">
                    <input type="email" name="email" value="<?= (isset($_GET['email'])) ? $_GET['email'] : 'example@ex.com'; ?>">
                </label>
                <div class="w-full flex flex-col flex-none">
                    <label class="text-xl font-thin capitalize" for="verificationCode">verification Code</label>
                    <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="verificationCode" value="<?= \Helpers\FormInputHandler::getPostVariable('verificationCode') ?>" id="verificationCode" placeholder="123456" autocomplete="off">
                </div>
                <button class="w-full max-sm:w-full h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold" type="submit">submit</button>
            </form>
        </div>

    </main>
<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'footer.php';
require_once INCLUDES . 'end.body.php';
?>