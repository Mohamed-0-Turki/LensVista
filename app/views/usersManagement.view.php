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
              <a href="<?= \Helpers\URLHelper::appendToBaseURL('dashboard/users/add-user/') ?>" class="hover:scale-105 duration-150 ease-in-out w-80 h-56 rounded-3xl leading-6 shadow-2xl shadow-slate-200 ring-1 ring-gray-900/5 p-10 flex flex-col justify-around">
                <span class="capitalize text-5xl font-bold"><i class="fa-solid fa-user-plus"></i></span>
                <p class="capitalize text-2xl font-medium">add user</p>
              </a>
              <a href="#" class="hover:scale-105 duration-150 ease-in-out w-80 h-56 rounded-3xl leading-6 shadow-2xl shadow-slate-200 ring-1 ring-gray-900/5 p-10 flex flex-col justify-around">
                <p class="capitalize text-2xl font-medium">number of users</p>
                <p class="capitalize text-5xl font-bold"><?= isset($data) ? $data['data']['numberOfUsers']: 0; ?></p>
              </a>
              <a href="#" class="hover:scale-105 duration-150 ease-in-out w-80 h-56 rounded-3xl leading-6 shadow-2xl shadow-slate-200 ring-1 ring-gray-900/5 p-10 flex flex-col justify-around">
                <p class="capitalize text-2xl font-medium">number of buyers</p>
                <p class="capitalize text-5xl font-bold"><?= isset($data) ? $data['data']['numberOfBuyer']: 0; ?></p>
              </a>
              <a href="#" class="hover:scale-105 duration-150 ease-in-out w-80 h-56 rounded-3xl leading-6 shadow-2xl shadow-slate-200 ring-1 ring-gray-900/5 p-10 flex flex-col justify-around">
                <p class="capitalize text-2xl font-medium">number of admins</p>
                <p class="capitalize text-5xl font-bold"><?= isset($data) ? $data['data']['numberOfAdmins']: 0; ?></p>
              </a>
            </div>

            <div class="w-full flex flex-col gap-5">
              <h1 class="capitalize font-bold text-4xl">Recent User Registrations</h1>
              <div class="w-[600px] max-sm:w-[300px]">
                <canvas class="w-full" id="myChart"></canvas>
              </div>
            </div>

            <div class="flex flex-col gap-5">
              <h1 class="capitalize font-bold text-4xl">users</h1>
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
                          name
                        </th>
                        <th scope="col" class="px-6 py-3">
                          gender
                        </th>
                        <th scope="col" class="px-6 py-3">
                          role
                        </th>
                        <th scope="col" class="px-6 py-3">
                          email
                        </th>
                        <th scope="col" class="px-6 py-3">
                          acount status
                        </th>
                        <th scope="col" class="px-6 py-3">
                          Account created
                        </th>
                        <th scope="col" class="px-6 py-3">
                          controllers
                        </th>
                    </tr>
                  </thead>
                  <tbody class="text-lg">
                    <?php
                      if (isset($data)): foreach ($data['data']['users'] as $user):
                    ?>
                    <tr class="bg-white border-b hover:bg-gray-50">
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $user['user_ID'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $user['first_name'] . ' ' . $user['last_name'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $user['gender'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $user['user_role'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $user['email'] ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= ($user['status'] == 1) ? 'Enabled': 'Not enabled'; ?>
                      </td>
                      <td class="px-6 py-4 font-semibold text-gray-900">
                        <?= $user['create_date'] ?>
                      </td>
                      <td class="px-6 py-4 flex flex-col gap-3">
                        <a href="<?= \Helpers\URLHelper::appendToBaseURL('dashboard/users/edit-user/') . $user['user_ID'] . '?userRole=' . $user['user_role'] ?>" class="w-20 h-10 flex items-center justify-center bg-turquoise-splash hover:bg-emerald-envy text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">edit</a>
                        <a href="<?= \Helpers\URLHelper::appendToBaseURL('dashboard/users/delete-user/') . $user['user_ID'] ?>" class="w-20 h-10 flex items-center justify-center bg-red hover:bg-solid-red text-lg font-bold tracking-wide capitalize truncate text-white rounded-lg  duration-150">delete</a>
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
    // Fetch the data from the server
    fetch('http://localhost/LensVista/users/getRecentUserRegistrations')
        .then(response => response.json())
        .then(data => {
            const recentUserRegistrations = data.numberOfRecentUserRegistrations;
            const labels = recentUserRegistrations.map(item => item.day);
            const userCounts = recentUserRegistrations.map(item => item.user_count);

            const ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Recent User Registrations',
                        data: userCounts,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                    return null;
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching the data:', error));
</script>


<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'end.body.php';
?>