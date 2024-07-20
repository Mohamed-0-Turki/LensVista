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
              <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/products/add-product') ?>" class="hover:scale-105 duration-150 ease-in-out w-80 h-56 rounded-3xl leading-6 shadow-2xl shadow-slate-200 ring-1 ring-gray-900/5 p-10 flex flex-col justify-around">
                <span class="capitalize text-5xl font-bold"><i class="fa-brands fa-product-hunt"></i></span>
                <p class="capitalize text-2xl font-medium">add product</p>
              </a>
              <a href="#" class="hover:scale-105 duration-150 ease-in-out w-80 h-56 rounded-3xl leading-6 shadow-2xl shadow-slate-200 ring-1 ring-gray-900/5 p-10 flex flex-col justify-around">
                <p class="capitalize text-2xl font-medium">number of products</p>
                <p class="capitalize text-5xl font-bold"><?= isset($data) ? $data['data']['numberOfFrames']: 0; ?></p>
              </a>
            </div>
            <div class="flex flex-col gap-5">
              <h1 class="capitalize font-bold text-4xl">products</h1>
              <div class="flex gap-5">
                <p class="text-lg font-medium text-midnight-sapphire">Sort:</p>
                <a class="text-lg font-medium underline text-blue"  href="?sort=DESC">most recent</a>
                <p class="text-lg font-medium text-midnight-sapphire">|</p>
                <a class="text-lg font-medium underline text-blue" href="?sort=ASC">oldest</a>
              </div>
              <div class="overflow-x-auto shadow-md sm:rounded-lg" id="orders-table">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                  <thead class="text-md text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-16 py-3">
                          #ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                          category
                        </th>
                        <th scope="col" class="px-6 py-3">
                          model
                        </th>
                        <th scope="col" class="px-6 py-3">
                          price (EGP)
                        </th>
                        <th scope="col" class="px-6 py-3">
                          gender
                        </th>
                        <th scope="col" class="px-6 py-3">
                          material
                        </th>
                        <th scope="col" class="px-6 py-3">
                          style
                        </th>
                        <th scope="col" class="px-6 py-3">
                          shape
                        </th>
                        <th scope="col" class="px-6 py-3">
                          nose pads
                        </th>
                    </tr>
                  </thead>
                  <tbody class="text-lg">
                    <?php if (isset($data)): foreach ($data['data']['frames'] as $frame): ?>
                    <tr class="bg-white border-b hover:bg-gray-50">
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $frame['frame_ID'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $frame['category_name'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $frame['model'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $frame['price'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $frame['gender'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $frame['frame_material'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $frame['frame_style'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $frame['frame_shape'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $frame['frame_nose_pads'] ?>
                      </td>
                      <td class="px-6 py-4 flex flex-col gap-3">
                        <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/products/edit-product/') . $frame['frame_ID'] ?>" class="w-20 h-10 flex items-center justify-center bg-turquoise-splash hover:bg-emerald-envy text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">edit</a>
                        <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/products/delete-product/') . $frame['frame_ID'] ?>" class="w-20 h-10 flex items-center justify-center bg-red hover:bg-solid-red text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">delete</a>
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


<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'end.body.php';
?>