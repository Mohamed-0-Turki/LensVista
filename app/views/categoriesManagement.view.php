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
              <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/categories/add-category') ?>" class="hover:scale-105 duration-150 ease-in-out w-80 h-56 rounded-3xl leading-6 shadow-2xl shadow-slate-200 ring-1 ring-gray-900/5 p-10 flex flex-col justify-around">
                <span class="capitalize text-5xl font-bold"><i class="fa-solid fa-layer-group"></i></span>
                <p class="capitalize text-2xl font-medium">add Category</p>
              </a>
              <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/categories/manage-categories') ?>" class="hover:scale-105 duration-150 ease-in-out w-80 h-56 rounded-3xl leading-6 shadow-2xl shadow-slate-200 ring-1 ring-gray-900/5 p-10 flex flex-col justify-around">
                <p class="capitalize text-2xl font-medium">number of categories</p>
                <p class="capitalize text-5xl font-bold"><?= isset($data) ? $data['data']['numberOfCategories']: 0; ?></p>
              </a>
            </div>
            <div class="flex flex-col gap-5">
              <h1 class="capitalize font-bold text-4xl">categories</h1>
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
                        <th scope="col" class="px-16 py-3">
                          Image
                        </th>
                        <th scope="col" class="px-6 py-3">
                          name
                        </th>
                        <th scope="col" class="px-6 py-3">
                          description
                        </th>
                        <th scope="col" class="px-6 py-3">
                          controllers
                        </th>
                    </tr>
                  </thead>
                  <tbody class="text-lg">
                    <?php if (isset($data)): foreach ($data['data']['categories'] as $category): ?>
                      <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold text-gray-900">
                          <?= $category['category_ID'] ?>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">
                          <img class="w-20 h-20 object-cover rounded-xl" src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . $category['image_url']) ?>" alt="" srcset="">
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">
                          <?= $category['name'] ?>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">
                          <?= $category['description'] ?>
                        </td>
                        <td class="px-6 py-4 flex flex-col gap-3">
                          <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/categories/edit-category/') . $category['category_ID'] ?>" class="w-20 h-10 flex items-center justify-center bg-turquoise-splash hover:bg-emerald-envy text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">edit</a>
                          <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/categories/delete-category/') . $category['category_ID'] ?>" class="w-20 h-10 flex items-center justify-center bg-red hover:bg-solid-red text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">delete</a>
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