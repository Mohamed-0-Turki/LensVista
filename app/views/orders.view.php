<?php
require_once INCLUDES . 'start.body.php';
require_once INCLUDES . 'header.php';
?>

    <main class="w-full h-fit min-h-dvh">

        <div class="p-20 w-full relative overflow-x-auto flex flex-col gap-5 shadow-md sm:rounded-lg max-sm:p-3" id="orders-table">
            <h1 class="text-6xl font-bold text-cerulean-depths tracking-wider capitalize max-sm:text-3xl">my orders</h1>
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
                <?php
                    if (isset($data)):
                        $orders = $data['data']['orders'];
                ?>
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
                <?php endif; ?>
            </table>
        </div>
    </main>

    <script>

    </script>

<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'footer.php';
require_once INCLUDES . 'end.body.php';
?>