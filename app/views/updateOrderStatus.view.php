<?php
require_once INCLUDES . 'start.body.php';
?>

    <main class="w-full h-fit min-h-dvh">

        <div class="w-full min-h-dvh grid grid-rows-10 grid-cols-12">

            <?php
            require_once INCLUDES . 'sideBar.php';
            require_once INCLUDES . 'navbar.php';
            ?>
            <section class="row-span-9 col-span-10 max-2xl:col-span-12">

                <div class="p-10 w-full flex flex-col items-center justify-center gap-10">
                    <?php 
                    if(isset($data['data'])): 
                        $orderData = $data['data'];
                    ?>
                        <form action="" method="post" class="w-[500px] h-fit flex flex-col items-start justify-between gap-6 max-sm:w-full">

                            <h1 class="text-5xl font-bold text-cerulean-depths max-md:text-4xl">Update order Status</h1>

                            <div class="flex flex-col gap-2">
                                <p class="text-xl flex flex-nowrap gap-2">
                                    <span class="font-bold text-midnight-sapphire">order ID:</span>
                                    <span><?= $orderData['order_ID'] ?></span>
                                </p>
                                <p class="text-xl flex flex-nowrap gap-2">
                                    <span class="font-bold text-midnight-sapphire">Buyer ID:</span>
                                    <span><?= $orderData['buyer_ID'] ?></span>
                                </p>
                                <p class="text-xl flex flex-nowrap gap-2">
                                    <span class="font-bold text-midnight-sapphire">name:</span>
                                    <span><?= $orderData['user_name'] ?></span>
                                </p>
                                <p class="text-xl flex flex-nowrap gap-2">
                                    <span class="font-bold text-midnight-sapphire">phone number:</span>
                                    <span><?= $orderData['phone_number'] ?></span>
                                </p>
                                <p class="text-xl flex flex-nowrap gap-2">
                                    <span class="font-bold text-midnight-sapphire">street address:</span>
                                    <span><?= $orderData['street_name'] ?></span>
                                </p>
                                <p class="text-xl flex flex-nowrap gap-2">
                                    <span class="font-bold text-midnight-sapphire">city:</span>
                                    <span><?= $orderData['city'] ?></span>
                                </p>
                                <p class="text-xl flex flex-nowrap gap-2">
                                    <span class="font-bold text-midnight-sapphire">nearest landmark:</span>
                                    <span><?= $orderData['nearest_landmark'] ?></span>
                                </p>
                                <p class="text-xl flex flex-nowrap gap-2">
                                    <span class="font-bold text-midnight-sapphire">building name/no:</span>
                                    <span><?= $orderData['building_name/no'] ?></span>
                                </p>
                            </div>

                            <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                                <label class="text-xl font-thin capitalize" for="status">Status</label>
                                <select name="status" id="status" class="appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-300">
                                    <option value="">-- select Status --</option>
                                    <option value="0" <?= ($orderData['order_status'] == 0)? 'selected': ''; ?>>cancel</option>
                                    <option value="1" <?= ($orderData['order_status'] == 1)? 'selected': ''; ?>>new</option>
                                    <option value="2" <?= ($orderData['order_status'] == 2)? 'selected': ''; ?>>recipient</option>
                                </select>
                            </div>

                            <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                                <label class="text-xl font-thin capitalize" for="phase">phase</label>
                                <select name="phase" id="phase" class="appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-300">
                                    <option value="">-- select phase --</option>
                                    <option value="0" <?= ($orderData['order_phase'] == 0)? 'selected': ''; ?>>order placed</option>
                                    <option value="1" <?= ($orderData['order_phase'] == 1)? 'selected': ''; ?>>processing</option>
                                    <option value="2" <?= ($orderData['order_phase'] == 2)? 'selected': ''; ?>>shipped</option>
                                    <option value="3" <?= ($orderData['order_phase'] == 3)? 'selected': ''; ?>>delivered</option>
                                </select>
                            </div>

                            <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                                <label class="text-xl font-thin capitalize" for="paymentStatus">payment Status</label>
                                <select name="paymentStatus" id="paymentStatus" class="appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-300">
                                    <option value="">-- select payment Status --</option>
                                    <option value="0" <?= ($orderData['payment_status'] == 0)? 'selected': ''; ?>>unpaid</option>
                                    <option value="1" <?= ($orderData['payment_status'] == 1)? 'selected': ''; ?>>paid</option>
                                </select>
                            </div>

                            <button class="w-48 h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold" type="submit">update</button>
                        </form>
                    <?php endif; ?>
                </div>


            </section>

        </div>
    </main>

    <script>

    </script>

<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'end.body.php';
?>