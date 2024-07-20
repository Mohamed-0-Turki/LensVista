<?php
require_once INCLUDES . 'start.body.php';
require_once INCLUDES . 'header.php';
?>

    <main class="w-full h-fit min-h-dvh">


        <div class="p-20 flex flex-col gap-10 max-sm:p-3">
            <h1 class="text-4xl font-bold">Shopping cart</h1>
            <?php if(isset($data['data']) && count($data['data']) != 0): ?>
                <div class="w-full flex flex-col items-center gap-10">
                    <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-md text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-16 py-3">
                                    Image
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    size
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    color
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    quantity
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody class="text-lg">
                            <?php foreach ($data['data'] as $item): ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="p-4">
                                        <img src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . $item['image_url']) ?>" class="w-16 md:w-32 max-w-full max-h-full" alt="">
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $item['model'] ?>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $item['frame_width'] ?>mm, <?= $item['bridge_width'] ?>mm, <?= $item['temple_length'] ?>mm
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <div class="w-10 h-10 rounded-full" style="background-color: #<?= $item['color'] ?>">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="w-28 h-12 flex items-center justify-evenly border-2 border-light-gray rounded-md">
                                            <a href="<?= \Helpers\URLHelper::appendToBaseURL('cart/updateCartItemQuantity/decrease/') . $item['cartItem_ID'] . '/' . $item['frameOption_ID'] ?>" type="button" id="btn-minus" class="font-bold cursor-pointer"><i class="fa-solid fa-minus"></i></a>
                                            <p class="w-1/2 text-center text-lg inline-block align-middle"><?= $item['quantity'] ?></p>
                                            <a href="<?= \Helpers\URLHelper::appendToBaseURL('cart/updateCartItemQuantity/increase/') . $item['cartItem_ID'] . '/' . $item['frameOption_ID'] ?>" type="button" id="btn-plus" class="font-bold cursor-pointer"><i class="fa-solid fa-plus"></i></a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        <?= $item['price'] ?> EGP
                                    </td>
                                    <td class="px-6 py-4 flex flex-col gap-3">
                                        <a href="<?= \Helpers\URLHelper::appendToBaseURL('products/index/') . $item['frame_ID'] ?>" class="w-20 h-10 flex items-center justify-center bg-cerulean-depths hover:bg-midnight-sapphire text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">details</a>
                                        <a href="<?= \Helpers\URLHelper::appendToBaseURL('cart/deleteItem/') . $item['cartItem_ID'] ?>" class="w-20 h-10 flex items-center justify-center bg-red hover:bg-solid-red text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="w-[500px] flex flex-col items-center gap-5 max-md:w-full">
                        <div class="w-full relative overflow-x-auto rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 overflow-x-auto">
                                <tbody>
                                <tr class="bg-gray-100 border-b-2">
                                    <th scope="row" class="px-6 py-4 font-medium text-slate-gray whitespace-nowrap">
                                        Subtotal
                                    </th>
                                    <td class="px-6 py-4">
                                        1000 EGP
                                    </td>
                                </tr>
                                <tr class="bg-gray-100 border-b-2">
                                    <th scope="row" class="px-6 py-4 font-medium text-slate-gray whitespace-nowrap">
                                        Shipping
                                    </th>
                                    <td class="px-6 py-4">
                                        0 EGP
                                    </td>
                                </tr>
                                <tr class="bg-gray-100 border-b-2">
                                    <th scope="row" class="px-6 py-4 font-medium text-slate-gray whitespace-nowrap">
                                        TAX
                                    </th>
                                    <td class="px-6 py-4">
                                        0 EGP
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <?php
                                    $total = 0;
                                    foreach ($data['data'] as $item):
                                        $total += $item['price'] * $item['quantity'];
                                    endforeach;
                                ?>
                                <tr class="font-semibold text-gray-900 bg-gray-100">
                                    <th scope="row" class="px-6 py-3 text-base">Total</th>
                                    <td class="px-6 py-3"><?= number_format($total) ?></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <form class="w-full h-fit" action="" method="post">
                            <button class="w-full h-12 rounded-md text-xl capitalize bg-turquoise-splash hover:bg-emerald-envy text-white ease-in-out duration-150 font-bold" type="submit" name="checkout">checkout <i class="fa-solid fa-money-bill"></i></button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if(isset($data['data']) && count($data['data']) == 0): ?>
            <div class="w-full h-full flex flex-col items-center justify-center">
                <p class="text-2xl font-bold text-gray-700">Empty Cart</p>
                <p class="text-sm text-gray-500 mt-2">Unfortunately, this product is currently not available.</p>
            </div>
        <?php endif; ?>

    </main>

    <script>

    </script>

<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'footer.php';
require_once INCLUDES . 'end.body.php';
?>