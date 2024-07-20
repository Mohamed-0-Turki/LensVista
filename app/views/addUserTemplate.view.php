<div class="p-20 flex flex-col items-center justify-center max-sm:p-3">
    <form action="" method="POST" class="h-fit flex flex-col items-start justify-between gap-6" id="add-user-form">
        <?php if(! isset($_SESSION['USER'])): ?>
            <h1 class="text-6xl font-bold text-cerulean-depths tracking-wider capitalize max-sm:text-3xl">
                Welcome To lensVista !
            </h1>
            <p class="text-3xl font-bold text-black capitalize max-sm:text-2xl">
                Register New Account
            </p>
        <?php else: ?>
            <p class="text-3xl font-bold text-black capitalize max-sm:text-2xl">
                <?= (isset($data) && isset($data['data']) && count($data['data']) > 0) ? '': 'add New'; ?> Account
            </p>
        <?php endif; ?>
        <?php
            if (isset($data) && isset($data['data']) && count($data['data']) > 0):
                $personalData = $data['data']['personalData'];
            endif;
        ?>
        <div class="w-full grid grid-cols-2 grid-rows-4 gap-10 max-md:items-center max-md:justify-center max-sm:grid-cols-1 max-sm:grid-rows-7">

            <div class="w-96 flex flex-col flex-none max-xl:w-full">
                <label class="text-xl font-thin capitalize" for="firstName">First Name</label>
                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="firstName" value="<?= (isset($personalData)) ? $personalData['first_name']: \Helpers\FormInputHandler::getPostVariable('firstName') ?>" id="firstName" placeholder="John">
                <span class="ml-3 text-red"></span>
            </div>

            <div class="w-96 flex flex-col flex-none max-xl:w-full">
                <label class="text-xl font-thin capitalize" for="lastName">Last Name</label>
                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="lastName" value="<?= (isset($personalData)) ? $personalData['last_name']: \Helpers\FormInputHandler::getPostVariable('lastName') ?>" id="lastName" placeholder="Robert">
                <span class="ml-3 text-red"></span>
            </div>

            <div class="w-96 flex flex-col flex-none max-xl:w-full">
                <label class="text-xl font-thin capitalize" for="birthDate">Birth Of Date</label>
                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="date" name="birthDate" value="<?= (isset($personalData)) ? $personalData['birth_date']: \Helpers\FormInputHandler::getPostVariable('birthDate') ?>" id="birthDate">
                <span class="ml-3 text-red"></span>
            </div>

            <!-- gender -->
            <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                <label class="text-xl font-thin capitalize" for="gender">gender</label>
                <select name="gender" id="gender" class="h-12 appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-150">
                    <option value="">-- select your gender --</option>
                    <option value="male" <?= (isset($personalData)) ? (($personalData['gender'] == 'male') ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('gender', 'male') ?>>male</option>
                    <option value="female" <?= (isset($personalData)) ? (($personalData['gender'] == 'female') ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('gender', 'female') ?>>female</option>
                </select>
            </div>

            <?php if(isset($_SESSION['USER']) && $_SESSION['USER']['role'] == 'admin'): ?>
            <!-- user role -->
                <?php if(! isset($personalData)): ?>
                    <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                        <label class="text-xl font-thin capitalize" for="userRole">user role</label>
                        <select name="userRole" id="userRole" class="h-12 appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-150">
                            <option value="">-- select user role --</option>
                            <option value="admin" <?= (isset($personalData)) ? (($personalData['user_role'] == 'admin') ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('userRole', 'admin') ?>>admin</option>
                            <option value="buyer" <?= (isset($personalData)) ? (($personalData['user_role'] == 'buyer') ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('userRole', 'buyer') ?>>buyer</option>
                        </select>
                    </div>
                <?php endif; ?>

                <!-- status -->
                <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                    <label class="text-xl font-thin capitalize" for="status">status</label>
                    <select name="status" id="status" class="h-12 appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-150">
                        <option value="">-- select account status --</option>
                        <option value="0" <?=  (isset($personalData)) ? (($personalData['status'] == 0) ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('status', '0') ?>>Not Enabled</option>
                        <option value="1" <?= (isset($personalData)) ? (($personalData['status'] == 1) ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('status', '1') ?>>Enabled</option>
                    </select>
                </div>
            <?php endif; ?>

            <!-- Email -->
            <div class="w-96 flex flex-col flex-none max-xl:w-full">
                <label class="text-xl font-thin capitalize" for="email">email</label>
                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="email" name="email" value="<?= (isset($personalData)) ? $personalData['email']: \Helpers\FormInputHandler::getPostVariable('email') ?>" id="email" placeholder="example@ex.com">
                <span class="ml-3 text-red"></span>
            </div>

            <?php if(isset($personalData)): ?>
                <!-- Old Password -->
                <div class="relative w-96 flex flex-col flex-none max-xl:w-full">
                    <label class="text-xl font-thin capitalize" for="oldPassword">old password</label>
                    <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="password" name="oldPassword" value="<?= \Helpers\FormInputHandler::getPostVariable('oldPassword') ?>" id="oldPassword">
                    <button class="absolute inset-y-0.4 right-5 top-10" id="eye" type="button">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Password -->
            <div class="relative w-96 flex flex-col flex-none max-xl:w-full">
                <label class="text-xl font-thin capitalize" for="password">password</label>
                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="password" name="password" value="<?= \Helpers\FormInputHandler::getPostVariable('password') ?>" id="password">
                <button class="absolute inset-y-0.4 right-5 top-10" id="eye" type="button">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>

            <div class="relative w-96 flex flex-col flex-none max-xl:w-full">
                <label class="text-xl font-thin capitalize" for="confirmPassword">Confirm password</label>
                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="password" name="confirmPassword" value="<?= \Helpers\FormInputHandler::getPostVariable('confirmPassword') ?>" id="confirmPassword">
                <button class="absolute inset-y-0.4 right-5 top-10" id="eye" type="button">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
        </div>

        <?php if(! isset($_SESSION['USER'])): ?>
            <div class="flex flex-row items-center gap-4">
                <input class="h-5 w-5 text-cerulean-depths focus:ring-slate-gray border-gray-300 rounded-md" type="checkbox" name="privacy" value="on" id="privacy" <?= \Helpers\FormInputHandler::getCheckedStatus('privacy', 'on') ?>>
                <label class="capitalize" for="privacy">
                    I Accept Terms Of Use & <a class="underline text-blue visited:text-purple" href="#">Privacy And Policy.</a>
                </label>
            </div>
        <?php endif; ?>
        
        <!-- Submit Btn -->
        <button class="w-48 h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold" type="submit">sign up</button>

        <?php if(! isset($_SESSION['USER'])): ?>
            <!-- Link login -->
            <p class="capitalize sm:tracking-widest">
                Already Have An Account ?
                <a class="underline text-blue visited:text-purple" href="<?= \Helpers\URLHelper::appendToBaseURL('login') ?>">login</a>
            </p>
        <?php endif; ?>

    </form>
    <!-- End Login -->
</div>
<script>
    const btnEyes = Array.from(document.querySelectorAll("#eye"));
    const passwords = Array.from(document.querySelectorAll('[type="password"]'));
    showPassword(btnEyes, passwords)
</script>