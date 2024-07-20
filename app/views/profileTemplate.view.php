    <main class="w-full h-fit min-h-dvh">
        <?php
        if (isset($data['data'])):
            $personalData = $data['data']['personalData'];
            $orders = $data['data']['orders'];
        ?>
            <div class="p-20 flex flex-row justify-around gap-5 max-lg:items-center max-lg:p-3 max-lg:flex-col-reverse">
                <div class="flex flex-col items-center justify-center">
                    <form action="" method="POST" enctype="multipart/form-data" class="h-fit flex flex-col items-start justify-between gap-6" id="profile-form">
                        <h1 class="text-6xl font-bold text-cerulean-depths tracking-wider capitalize max-sm:text-3xl">
                            <?= $personalData['first_name'] . ' ' . $personalData['last_name'] ?>
                        </h1>

                        <div class="w-full h-fit flex flex-col gap-3 items-center justify-center">
                            <?php if ($personalData['image_url'] == null && $personalData['gender'] == 'male'): ?>
                                <img src="<?= \Helpers\URLHelper::appendToBaseURL('public/assets/images/3d-cute-cartoon-boy-with-backpack-his-back.jpg') ?>" alt="" class="w-64 h-64 rounded-full bg-black">
                            <?php elseif ($personalData['image_url'] == null && $personalData['gender'] == 'female'): ?>
                                <img src="<?= \Helpers\URLHelper::appendToBaseURL('public/assets/images/3d-cute-cartoon-girl-with-brown-hair-eyeglasses.jpg') ?>" alt="" class="w-64 h-64 rounded-full bg-black">
                            <?php else:  ?>
                                <img src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/') . $personalData['image_url'] ?>" alt="" class="w-64 h-64 rounded-full bg-black">
                            <?php endif; ?>
                            <?php if ($personalData['image_url'] != null): ?>
                                <a href="<?= \Helpers\URLHelper::appendToBaseURL('session/deleteProfileImage/') . $personalData['user_ID'] ?>" class="w-40 h-10 flex items-center justify-center bg-red hover:bg-solid-red text-base font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">delete image</a>
                            <?php endif; ?>
                        </div>

                        <p class="flex flex-col gap-1 text-3xl font-bold text-black capitalize max-sm:text-2xl">
                            personal data
                            <span class="text-sm leading-6 text-gray-600">This information will be displayed publicly so be careful what you share.</span>
                        </p>
                        <div class="w-full grid grid-cols-2 grid-rows-5 gap-10 max-md:items-center max-md:justify-center max-sm:grid-cols-1 max-sm:grid-rows-9">

                            <div class="row-span-3 max-xl:row-span-2 w-fit h-full flex flex-col gap-2 items-center justify-between">
                                <label for="image-input" class="grow overflow-hidden relative w-96 max-xl:w-full h-full flex flex-col items-center justify-center border-2 border-light-gray hover:border-slate-gray duration-150 ease-in-out cursor-pointer">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Upload your avatar</span>
                                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                    <input id="image-input" type="file" name="userImage" class="hidden">
                                    <img class="absolute object-fill" src="" alt="" id="image">
                                </label>
                                <p class="text-sm leading-6 text-gray-600">Please use the following <a class="underline capitalize text-blue" target="_blank" href="https://redketchup.io/image-resizer">link</a> to adjust the size of the images.</p>
                            </div>

                            <div class="w-96 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="firstName">First Name</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="firstName" value="<?= $personalData['first_name'] ?>" id="firstName" placeholder="John">
                            </div>

                            <div class="w-96 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="lastName">Last Name</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="lastName" value="<?= $personalData['last_name'] ?>" id="lastName" placeholder="Robert">
                            </div>

                            <div class="w-96 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="birthDate">Birth Of Date</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="date" name="birthDate" value="<?= $personalData['birth_date'] ?>" id="birthDate" placeholder="Robert">
                            </div>

                            <!-- gender -->
                            <div class="w-96 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="gender">gender</label>
                                <select name="gender" id="gender" class="appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-300">
                                    <option value="">-- select your gender --</option>
                                    <option value="male" <?= ($personalData['gender'] == 'male') ? 'selected': ''; ?>>male</option>
                                    <option value="female" <?= ($personalData['gender'] == 'female') ? 'selected': ''; ?>>female</option>
                                </select>
                            </div>

                            <!-- Email -->
                            <div class="w-96 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="email">email</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="email" name="email" value="<?= $personalData['email'] ?>" id="email" placeholder="Enter your email">
                            </div>

                            <!-- Old Password -->
                            <div class="relative w-96 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="oldPassword">old password</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="password" name="oldPassword" value="" id="oldPassword">
                                <button class="absolute inset-y-0.4 right-5 top-10" id="eye" type="button">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>

                            <!-- new Password -->
                            <div class="relative w-96 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="newPassword">new password</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="password" name="newPassword" value="" id="newPassword">
                                <button class="absolute inset-y-0.4 right-5 top-10" id="eye" type="button">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>

                            <div class="relative w-96 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="confirmPassword">Confirm password</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="password" name="confirmPassword" value="" id="confirmPassword">
                                <button class="absolute inset-y-0.4 right-5 top-10" id="eye" type="button">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>

                            <!-- phone number -->
                            <div class="w-96 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="phone number">phone number</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="phoneNumber" value="<?= ($personalData['phone_number'] != null) ? $personalData['phone_number']: ''; ?>" id="phone number" placeholder="+20 xxx xxx xxxx">
                            </div>
                        </div>

                        <p class="flex flex-col gap-1 text-3xl font-bold text-black capitalize max-sm:text-2xl">
                            location data
                            <span class="text-sm leading-6 text-gray-600">Use a permanent address where you can receive order.</span>
                        </p>

                        <div class="w-full grid grid-cols-3 grid-flow-row gap-10 max-md:items-center max-md:justify-center max-sm:grid-cols-1">

                            <div class="col-span-3 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="streetAddress">Street address</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="streetAddress" value="<?= ($personalData['street_name'] != null) ? $personalData['street_name']: ''; ?>" id="streetAddress" placeholder="">
                            </div>

                            <div class="max-md:col-span-2 max-sm:col-span-3 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="city">City</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="city" value="<?= ($personalData['city'] != null) ? $personalData['city']: ''; ?>" id="city" placeholder="giza">
                            </div>
                            <div class="max-md:col-span-2 max-sm:col-span-3 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="nearestLandMark">nearest landmark</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="nearestLandMark" value="<?= ($personalData['nearest_landmark'] != null) ? $personalData['nearest_landmark']: ''; ?>" id="nearestLandMark" placeholder="mall">
                            </div>
                            <div class="max-md:col-span-2 max-sm:col-span-3 flex flex-col flex-none max-xl:w-full">
                                <label class="text-xl font-thin capitalize" for="buildingName">building name/no</label>
                                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="buildingName" value="<?= ($personalData['building_name/no'] != null) ? $personalData['building_name/no']: ''; ?>" id="buildingName" placeholder="0">
                            </div>
                        </div>

                        <!-- Submit Btn -->
                        <button class="w-48 max-sm:w-full h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold" type="submit">update</button>

                    </form>
                    <div class="hidden w-full relative overflow-x-auto shadow-md sm:rounded-lg" id="orders-table">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-md text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-16 py-3">
                                    Order status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Payment status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    quantity
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Order details
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    The date of order
                                </th>
                            </tr>
                            </thead>
                            <tbody class="text-lg">
                            <?php
                            foreach ($orders as $order):
                                $status = ($order['order_status'] == 1) ? 'new' : (($order['order_status'] == 0) ? 'Canceled' : 'Recipient');
                                $statusColor = ($order['order_status'] == 1) ? 'turquoise-splash' : (($order['order_status'] == 0) ? 'red' : 'blue');
                                $payment = ($order['payment_status'] == 1) ? 'paid' : 'unpaid';
                            ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-semibold text-<?= $statusColor ?>">
                                        <?= $status ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $payment ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $order['total_price'] ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $order['order_quantity'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="<?=  \Helpers\URLHelper::appendToBaseURL('Orders/orderDetails/') . $order['order_ID'] ?>" class="w-20 h-10 flex items-center justify-center bg-cerulean-depths hover:bg-midnight-sapphire text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">details</a>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $order['create_date'] ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="p-5 w-80 h-fit flex flex-col gap-5 justify-around bg-gray-100 rounded-lg max-sm:w-full">
                    <button id="profile-form-btn" class="w-full h-12 flex flex-row items-center justify-around rounded-lg bg-white text-slate-gray hover:bg-slate-gray hover:text-white text-xl ease-in-out duration-150">
                        <span>profile</span>
                        <i class="fa-solid fa-address-card"></i>
                    </button>
                    <button id="orders-table-btn" class="w-full h-12 flex flex-row items-center justify-around rounded-lg bg-white text-slate-gray hover:bg-slate-gray hover:text-white text-xl ease-in-out duration-150">
                        <span>orders</span>
                        <i class="fa-solid fa-border-all"></i>
                    </button>
                    <?php if($_SESSION['USER']['role'] == 'admin'): ?>
                      <a href="<?= \Helpers\URLHelper::appendToBaseURL('users/changeAccountStatus/') . $personalData['user_ID'] . '?userRole=' . $personalData['user_role']?>" class="w-full h-12 flex flex-row items-center justify-around rounded-lg bg-cerulean-depths hover:bg-midnight-sapphire text-white text-xl ease-in-out duration-150">
                          <span><?= ($personalData['status'] == 1) ? 'Disable the account': 'Activate the account' ?></span>
                          <?php if(($personalData['status'] == 1)): ?>
                              <i class="fa-solid fa-handshake-slash"></i>
                            <?php else: ?>
                              <i class="fa-solid fa-handshake"></i>
                          <?php endif; ?>
                      </a>
                    <?php endif; ?>
                    <?php $link = ($_SESSION['USER']['role'] == 'admin') ? 'dashboard/users/delete-user/': 'session/deleteAccount/'; ?>
                    <a href="<?= \Helpers\URLHelper::appendToBaseURL($link) . $personalData['user_ID'] ?>" class="w-full h-12 flex flex-row items-center justify-around rounded-lg bg-red hover:bg-solid-red text-white text-xl ease-in-out duration-150">
                        <span>delete Account</span>
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="w-full h-full flex flex-col items-center justify-center">
                <p class="text-2xl font-bold text-gray-700">Unable to Retrieve Data</p>
                <p class="text-sm text-gray-500 mt-2">There Is No Data For This User</p>
            </div>
        <?php endif; ?>
    </main>

    <script>
        const btnEyes = Array.from(document.querySelectorAll("#eye"));
        const passwords = Array.from(document.querySelectorAll('[type="password"]'));
        showPassword(btnEyes, passwords)

        const inputFile = document.querySelector("#image-input")
        const image = document.querySelector("#image")
        changeImageSrc(inputFile, image)

        const profileFormBtn = document.querySelector("#profile-form-btn");
        const profileForm = document.querySelector("#profile-form");
        const ordersTableBtn = document.querySelector("#orders-table-btn");
        const ordersTable = document.querySelector("#orders-table");

        [profileFormBtn, ordersTableBtn].forEach((btn) => {
            btn.addEventListener("click", () => {
                let index = [profileFormBtn, ordersTableBtn].indexOf(btn);
                let sections = [profileForm, ordersTable];
                sections.forEach((section) => {
                    if (! section.classList.contains("hidden")) {
                        section.classList.add("hidden");
                    }
                });
                sections[index].classList.toggle("hidden");
            });
        });
    </script>