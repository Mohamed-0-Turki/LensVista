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
          <div class="p-10 w-full flex flex-col items-center justify-center gap-10">
            <form action="" enctype="multipart/form-data" method="post" class="w-[500px] h-fit flex flex-col items-start justify-between gap-6 max-sm:w-full">

              <h1 class="text-5xl font-bold text-cerulean-depths max-md:text-4xl"><?= (isset($data) && count($data['data']) > 0) ? 'Edit' : 'Add'; ?> Category</h1>
      
              <div class="w-full">
                <label class="text-xl font-thin capitalize" for="description">cover photo</label>
                <div class="mt-2 flex justify-center">
                  <label for="input-image" class="overflow-hidden relative w-96 max-sm:w-full h-64 flex flex-col items-center justify-center border-2 border-light-gray hover:border-slate-gray duration-150 ease-in-out cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Upload a file</span>
                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                    <input id="input-image" name="categoryImage" type="file" <?= (isset($data) && count($data['data']) > 0) ? $data['data'][0]['image_url'] : ''; ?> class="hidden">
                    <img id="image" class="absolute object-contain" src="<?= (isset($data) && count($data['data']) > 0) ? \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . $data['data'][0]['image_url']) : ''; ?>" alt="">
                  </label>
                </div>
                <p class="text-sm leading-6 text-gray-600">Please use the following <a class="underline capitalize text-blue" target="_blank" href="https://redketchup.io/image-resizer">link</a> to adjust the size of the images.</p>
              </div>

              <?php 
                if(isset($data) && count($data['data']) > 0) {
                  $categoryID = $data['data'][0]['category_ID'];
                  echo "<input hidden name='categoryID' value='$categoryID'>";
                }
              ?>

              <div class="w-80 flex flex-col flex-none max-xl:w-full">
                <label class="text-xl font-thin capitalize" for="categoryTitle">Title</label>
                <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="categoryName" value="<?= (isset($data) && count($data['data']) > 0) ? $data['data'][0]['name'] : \Helpers\FormInputHandler::getPostVariable('categoryName'); ?>" id="categoryTitle" placeholder="example">
              </div>

              <div class="w-full flex flex-col flex-none max-xl:w-full">
                <label class="text-xl font-thin capitalize" for="description">description</label>
                <textarea name="categoryDescription" id="description" class="focus:border-cerulean-depths outline-none w-full h-20 border-2 rounded-md px-3 ease-in-out duration-150"><?= (isset($data) && count($data['data']) > 0) ? $data['data'][0]['description'] : \Helpers\FormInputHandler::getPostVariable('categoryDescription'); ?></textarea>
                <p class="text-sm leading-6 text-gray-600">Write a few sentences about this category.</p>
              </div>

              <button class="w-48 h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold" type="submit"><?= (isset($data) && count($data['data']) > 0) ? 'Edit' : 'Add'; ?>  Category</button>
            </form>
          </div>
        </section>

        </div>
    </main>

    <script>
      const inputFile = document.querySelector("#input-image");
      const image = document.querySelector("#image");

      inputFile.addEventListener("change", () => {
        image.src = URL.createObjectURL(inputFile.files[0])
      })
    </script>

<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'end.body.php';
?>