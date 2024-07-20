<?php
require_once INCLUDES . 'start.body.php';
?>

    <main class="w-full h-fit min-h-dvh">

        <div class="w-full min-h-dvh grid grid-rows-10 grid-cols-12">

        <?php
            require_once INCLUDES . 'sideBar.php';
            require_once INCLUDES . 'navbar.php';
            $feedback = [];
            if(isset($data) && count($data['data']) > 0) {
              $feedback = $data['data'][0];
            }
        ?>
        <section class="row-span-9 col-span-10 max-2xl:col-span-12">
          <div class="p-10 w-full flex flex-col items-center justify-center gap-10">
            <form action="<?= Helpers\URLHelper::appendToBaseURL('dashboard/feedbacks/notify-user/') . $feedback['feedback_ID'] ?>" method="post" class="w-[500px] h-fit flex flex-col items-start justify-between gap-6 max-sm:w-full">

              <h1 class="text-5xl font-bold text-cerulean-depths max-md:text-4xl">Send Email</h1>

              <div class="flex flex-col gap-2">
                <p class="text-xl flex flex-nowrap gap-2"><span class="font-bold text-midnight-sapphire">Feedback ID:</span>
                  <span><?= $feedback['feedback_ID'] ?></span>
                </p>
                <p class="text-xl flex flex-nowrap gap-2"><span class="font-bold text-midnight-sapphire">name:</span>
                  <span><?= $feedback['first_name'] . ' ' . $feedback['last_name'] ?></span>
                </p>
                <p class="text-xl flex flex-nowrap gap-2"><span class="font-bold text-midnight-sapphire">email:</span>
                  <span><?= $feedback['email'] ?></span>
                </p>
                <p class="text-xl flex flex-nowrap gap-2"><span class="font-bold text-midnight-sapphire">phone number:</span>
                  <span><?= $feedback['phone_number'] ?></span>
                </p>
                <p class="text-xl flex flex-nowrap gap-2"><span class="font-bold text-midnight-sapphire">create date:</span>
                  <span><?= $feedback['create_date'] ?></span>
                </p>
                <p class="text-xl flex flex-nowrap gap-2">
                  <span class="font-bold text-midnight-sapphire">message:
                    <span class="font-normal text-black">
                      <?= $feedback['message'] ?>
                    </span>
                  </span>
                </p>
              </div>
      
              <div class="w-full h-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                <label class="text-xl font-thin capitalize" for="message">message</label>
                <textarea class="h-full appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-150" name="message" id=""></textarea>
              </div>
      
              <button class="w-48 h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold" type="submit">send</button>
            </form>
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