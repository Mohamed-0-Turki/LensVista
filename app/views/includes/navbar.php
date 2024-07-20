<nav class="h-20 row-span-1 col-span-10 max-2xl:col-span-12 bg-midnight-sapphire px-5 w-full flex items-center justify-between">
      <button type="button" class="2xl:hidden w-10 h-10 rounded-lg bg-white hover:bg-cerulean-depths duration-150 ease-in-out" id="dashboard-side-bar-open-btn">
        <span class="font-4xl font-bold">
          <i class="fa-solid fa-bars"></i>
        </span>
      </button>
      <a href="<?= Helpers\URLHelper::appendToBaseURL('dashboard') ?>" class="font-extrabold text-4xl max-sm:text-3xl">
        <span class="text-white tracking-wide capitalize">dashboard</span>
      </a>

      <div class="relative">
        <!-- Btn To Show User drop-down menu -->
        <button class="overflow-hidden w-12 h-12 text-2xl border-0 rounded-full text-white bg-sunburst-gold hover:bg-goldenrod-blaze ease-in-out duration-150 max-sm:w-10 max-sm:h-10" id="user-menu-btn">
          <i class="fa-solid fa-user"></i>
        </button>
  
        <!-- Start User drop-down menu -->
        <div class="z-40 hidden absolute w-80 top-16 right-0 bg-white overflow-hidden rounded-3xl leading-6 shadow-2xl ring-1 ring-gray-900/5 animate-fadeOn" id="user-menu">
          <ul class="flex flex-col text-2xl text-midnight-sapphire p-4">
            <li class="group w-full h-20 rounded-3xl hover:bg-light-gray ease-in-out duration-150">
              <a class="group-hover:text-cerulean-depths h-full flex flex-row items-center justify-around" href="<?= Helpers\URLHelper::appendToBaseURL('dashboard/users/edit-user/') . $_SESSION['USER']['userID'] . '?userRole=' . $_SESSION['USER']['role'] ?>">
                <p class="capitalize">Account</p>
                <i class="fa-solid fa-user"></i>
              </a>
            </li>
            <li class="group w-full h-20 rounded-3xl hover:bg-light-gray ease-in-out duration-150">
              <a class="group-hover:text-cerulean-depths h-full flex flex-row items-center justify-around" href="<?= Helpers\URLHelper::appendToBaseURL('dashboard') ?>">
                <p class="capitalize">dashboard</p>
                <i class="fa-solid fa-chart-line"></i>
              </a>
            </li>
            <li class="group w-full h-20 rounded-3xl hover:bg-light-gray ease-in-out duration-150">
              <a class="group-hover:text-cerulean-depths h-full flex flex-row items-center justify-around" href="<?= Helpers\URLHelper::appendToBaseURL('session/logout') ?>">
                <p class="capitalize">logout</p>
                <i class="fa-solid fa-person-running"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>