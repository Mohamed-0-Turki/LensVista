<?php
    if (isset($data)):
        $order = $data['data']['order'];
        $orderItems = $data['data']['orderItems'];
    ?>
        <div class="p-10 flex flex-col gap-5 max-sm:p-3">
            <div class="flex flex-row flex-wrap gap-3 items-center justify-between">
                <h1 class="font-bold text-3xl text-midnight-sapphire capitalize">order #<?= $order['order_ID'] ?></h1>
                <p class="text-lg leading-6 text-gray-600 text-balance col-span-1">Order placed <?= $order['create_date'] ?></p>
            </div>

            <?php
                $status = ($order['order_status'] == 1) ? 'new' : (($order['order_status'] == 0) ? 'Canceled' : 'Recipient');
                $statusColor = ($order['order_status'] == 1) ? 'turquoise-splash' : (($order['order_status'] == 0) ? 'red' : 'blue');
                $payment = ($order['payment_status'] == 1) ? 'paid' : 'unpaid';
            ?>

            <div class="flex flex-row flex-wrap gap-3 items-center justify-between">
                <h1 class="font-bold text-3xl text-midnight-sapphire capitalize">Total price: <?= $order['total_price'] ?> <span class="uppercase">egp</span></h1>
                <p class="text-lg leading-6 text-gray-600 text-balance col-span-1">Order status: <span class="text-<?= $statusColor ?>"><?= $status ?></span></p>
            </div>

            <div class="h-20 flex items-center justify-center flex-col gap-8">
                <div class="relative w-full h-2 bg-gray-400 rounded-full flex items-center justify-between">
                    <span class="z-10 w-10 h-10 max-lg:w-5 max-lg:h-5 rounded-full bg-<?= ($order['order_phase'] >= 0) ? 'turquoise-splash' : 'gray-400'; ?>"></span>
                    <span class="z-10 w-10 h-10 max-lg:w-5 max-lg:h-5 rounded-full bg-<?= ($order['order_phase'] >= 1) ? 'turquoise-splash' : 'gray-400'; ?>"></span>
                    <span class="z-10 w-10 h-10 max-lg:w-5 max-lg:h-5 rounded-full bg-<?= ($order['order_phase'] >= 2) ? 'turquoise-splash' : 'gray-400'; ?>"></span>
                    <span class="z-10 w-10 h-10 max-lg:w-5 max-lg:h-5 rounded-full bg-<?= ($order['order_phase'] >= 3) ? 'turquoise-splash' : 'gray-400'; ?>"></span>
                    <div class="absolute h-2 bg-turquoise-splash rounded-full" style="width: <?= (((int)$order['order_phase'] * 4) / 12) * 100 ?>%"></div>
                </div>
                <div class="w-full flex items-center justify-between">
                    <span class="text-lg max-md:text-sm capitalize text-<?= ($order['order_phase'] >= 0) ? 'turquoise-splash' : 'gray-400'; ?>">Order placed</span>
                    <span class="text-lg max-md:text-sm capitalize text-<?= ($order['order_phase'] >= 1) ? 'turquoise-splash' : 'gray-400'; ?>">Processing</span>
                    <span class="text-lg max-md:text-sm capitalize text-<?= ($order['order_phase'] >= 2) ? 'turquoise-splash' : 'gray-400'; ?>">Shipped</span>
                    <span class="text-lg max-md:text-sm capitalize text-<?= ($order['order_phase'] >= 3) ? 'turquoise-splash' : 'gray-400'; ?>">Delivered</span>
                </div>
            </div>

            <?php if ($order['order_phase'] != 3 && $order['order_status'] != 0): ?>
                <div class="flex flex-row flex-wrap gap-3 items-center justify-between">
                    <a href="<?= \Helpers\URLHelper::appendToBaseURL('Orders/cancelOrder/') . $order['user_ID'] . '/' . $order['order_ID'] ?>" class="w-44 h-10 text-xl font-bold text-white capitalize bg-red hover:bg-solid-red rounded-lg duration-150 ease-in-out flex items-center justify-center">Cancelling order</a>
                </div>
            <?php endif; ?>
            <div class="flex flex-col gap-5">

                <?php foreach ($orderItems as $orderItem): ?>
                    <div class="p-8 w-full h-fit rounded-md leading-6  hover:scale-105 hover:shadow-2xl shadow-md ring-1 ring-gray-900/5 flex flex-col gap-10 duration-150 ease-in-out">
                        <div class="grid grid-cols-4 gap-5 max-xl:flex max-xl:flex-col">
                            <div class="flex flex-col gap-3 col-span-2">
                                <h1 class="font-medium text-xl capitalize"><?= $orderItem['frame_model'] ?></h1>
                                <p class="text-lg leading-6 text-black text-balance capitalize">price: <?= $orderItem['frame_price'] ?> <span class="uppercase">egp</span></p>

                                <p class="text-lg leading-6 text-black text-balance capitalize">gender: <?= $orderItem['frame_gender'] ?></p>

                                <p class="text-lg leading-6 text-gray-600 text-balance"><?= $orderItem['frame_description'] ?></p>
                            </div>

                            <div class="flex flex-col gap-3 col-span-1">
                                <h1 class="font-medium text-xl capitalize">design</h1>
                                <div class="flex flex-col max-xl:items-center max-xl:justify-between gap-3 max-xl:grid max-xl:grid-cols-3 max-md:grid-cols-2">
                                    <div class="flex flex-row items-center gap-3 col-span-1"><span class="text-lg leading-6 text-gray-600 text-balance">color:</span><div class="w-5 h-5 rounded-full" style="background-color: #<?= $orderItem['frame_color'] ?>" ></div></div>
                                    <p class="text-lg leading-6 text-gray-600 text-balance col-span-1">quantity: <?= $orderItem['frame_quantity'] ?></p>
                                    <p class="text-lg leading-6 text-gray-600 text-balance col-span-1">Material: <?= $orderItem['frame_material'] ?></p>
                                    <p class="text-lg leading-6 text-gray-600 text-balance col-span-1">Style: <?= $orderItem['frame_style'] ?></p>
                                    <p class="text-lg leading-6 text-gray-600 text-balance col-span-1">Shape: <?= $orderItem['frame_shape'] ?></p>
                                    <p class="text-lg leading-6 text-gray-600 text-balance col-span-1">Nose Pads: <?= $orderItem['frame_nose_pads'] ?></p>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 col-span-1">
                                <h1 class="font-medium text-xl capitalize">size</h1>
                                <p class="text-lg leading-6 text-gray-600 text-balance">Frame Width (mm): <?= $orderItem['frame_width'] ?></p>
                                <p class="text-lg leading-6 text-gray-600 text-balance">Bridge Width (mm): <?= $orderItem['frame_bridge_width'] ?></p>
                                <p class="text-lg leading-6 text-gray-600 text-balance">Temple Length (mm): <?= $orderItem['frame_temple_length'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="w-full h-full flex flex-col items-center justify-center">
            <p class="text-2xl font-bold text-gray-700">Unable to Retrieve Data</p>
            <p class="text-sm text-gray-500 mt-2">There Is No Data For This order</p>
        </div>
    <?php endif; ?>