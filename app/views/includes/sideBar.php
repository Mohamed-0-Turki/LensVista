<aside class="z-30 h-full row-span-10 col-span-2 flex flex-col gap-10 p-3 max-2xl:col-span-0 max-2xl:hidden max-2xl:absolute max-2xl:w-80 max-2xl:bg-white leading-6 shadow-2xl ring-1 ring-gray-900/5" id="dashboard-side-bar">
      <button type="button" class="2xl:hidden w-10 h-10 rounded-lg text-white bg-midnight-sapphire hover:bg-cerulean-depths duration-150 ease-in-out" id="dashboard-side-bar-close-btn">
        <span class="font-4xl font-bold">
          <i class="fa-solid fa-x"></i>
        </span>
      </button>
      <a href="<?= Helpers\URLHelper::appendToBaseURL('home') ?>" class="w-full text-4xl text-center font-extrabold capitalize text-midnight-sapphire">LensVista</a>
      <ul class="flex flex-col text-2xl text-midnight-sapphire p-4">
        <li class="group w-full h-20 rounded-3xl hover:bg-light-gray ease-in-out duration-150">
          <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard') ?>" class="group-hover:text-cerulean-depths w-full h-full flex flex-row gap-2 items-center justify-between px-5">
            <p class="capitalize">dashboard</p>
            <i class="fa-solid fa-chart-line"></i>
          </a>
        </li>
        <li class="group w-full h-20 rounded-3xl hover:bg-light-gray ease-in-out duration-150">
          <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/users/manage-users') ?>" class="group-hover:text-cerulean-depths w-full h-full flex flex-row gap-2 items-center justify-between px-5">
            <p class="capitalize">users</p>
            <i class="fa-solid fa-users"></i>
          </a>
        </li>
        <li class="group w-full h-20 rounded-3xl hover:bg-light-gray ease-in-out duration-150">
          <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/categories/manage-categories') ?>" class="group-hover:text-cerulean-depths w-full h-full flex flex-row gap-2 items-center justify-between px-5">
            <p class="capitalize">categories</p>
            <i class="fa-solid fa-layer-group"></i>
          </a>
        </li>
        <li class="group w-full h-20 rounded-3xl hover:bg-light-gray ease-in-out duration-150">
          <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/products/manage-products') ?>" class="group-hover:text-cerulean-depths w-full h-full flex flex-row gap-2 items-center justify-between px-5">
            <p class="capitalize">products</p>
            <i class="fa-brands fa-product-hunt"></i>
          </a>
        </li>
        <li class="group w-full h-20 rounded-3xl hover:bg-light-gray ease-in-out duration-150">
          <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/orders/manage-orders') ?>" class="group-hover:text-cerulean-depths w-full h-full flex flex-row gap-2 items-center justify-between px-5">
            <p class="capitalize">orders</p>
            <i class="fa-solid fa-border-top-left"></i>
          </a>
        </li>
        <li class="group w-full h-20 rounded-3xl hover:bg-light-gray ease-in-out duration-150">
          <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/feedbacks/manage-feedbacks') ?>" class="group-hover:text-cerulean-depths w-full h-full flex flex-row gap-2 items-center justify-between px-5">
            <p class="capitalize">feedbacks</p>
            <i class="fa-solid fa-comments"></i>
          </a>
        </li>
      </ul>
    </aside>