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
            <div class="p-10 w-full flex flex-col gap-10">
                <div class="w-full flex flex-wrap gap-10 items-center justify-center">
                    <a href="?duration=sinceTheBeginning" class="hover:scale-105 duration-150 ease-in-out w-80 h-56 rounded-3xl leading-6 shadow-2xl shadow-slate-200 ring-1 ring-gray-900/5 p-10 flex flex-col justify-around">
                        <p class="capitalize text-2xl font-medium">number of orders</p>
                        <p class="capitalize text-5xl font-bold"><?= isset($data) ? $data['data']['numberOfOrders']: 0; ?></p>
                        <p class="capitalize text-xl font-medium">Since the beginning</p>
                    </a>
                    <a href="?duration=resentOrders" class="hover:scale-105 duration-150 ease-in-out w-80 h-56 rounded-3xl leading-6 shadow-2xl shadow-slate-200 ring-1 ring-gray-900/5 p-10 flex flex-col justify-around">
                        <p class="capitalize text-2xl font-medium">Number of orders</p>
                        <p class="capitalize text-5xl font-bold"><?= isset($data) ? $data['data']['numberOfResentOrders']: 0; ?></p>
                        <p class="capitalize text-xl font-medium">last 24 hours</p>
                    </a>
                </div>

                <!-- <button class="capitalize w-16 h-10 bg-cerulean-depths hover:bg-midnight-sapphire rounded-lg text-lg text-white duration-150 ease-in-out">
                  filter
                </button>

                <form class="w-full h-fit p-3 flex flex-col">
                  <div class="">
                    <input type="checkbox" name="" id="">
                    <label for="">status</label>
                  </div>
                </form> -->

                <div class="flex flex-col gap-5">
                    <h1 class="capitalize font-bold text-4xl">orders</h1>
                    <div class="overflow-x-auto shadow-md sm:rounded-lg" id="orders-table">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-md text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-16 py-3">
                                    #ID
                                </th>
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
                                if (isset($data)): foreach ($data['data']['orders'] as $order):
                                    $status = ($order['order_status'] == 1) ? 'new' : (($order['order_status'] == 0) ? 'Canceled' : 'Recipient');
                                    $statusColor = ($order['order_status'] == 1) ? 'turquoise-splash' : (($order['order_status'] == 0) ? 'red' : 'blue');
                                    $payment = ($order['payment_status'] == 1) ? 'paid' : 'unpaid';
                                ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $order['order_ID'] ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-<?= $statusColor ?>">
                                        <?= $status ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $payment ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $order['total_price'] ?> EGP
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $order['order_quantity'] ?>
                                    </td>
                                    <td class="px-6 py-4 flex flex-col gap-3">
                                        <a href="<?=  \Helpers\URLHelper::appendToBaseURL('dashboard/orders/order-details/') . $order['order_ID'] ?>" class="w-20 h-10 flex items-center justify-center bg-cerulean-depths hover:bg-midnight-sapphire text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">details</a>
                                        <a href="<?=  \Helpers\URLHelper::appendToBaseURL('dashboard/orders/update-order/') . $order['order_ID'] ?>" class="w-20 h-10 flex items-center justify-center bg-turquoise-splash hover:bg-emerald-envy text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">update</a>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $order['create_date'] ?>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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