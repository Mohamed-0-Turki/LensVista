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

          <div class="w-full flex flex-col items-center justify-center gap-10">
            <?php
              $images = $options = $categories = $frameStyleOptions = $frameShapeOptions = $frameMaterialOptions = $frameNosePadsOptions = [];
              $frameID = \Helpers\FormInputHandler::getPostVariable('frameID');
              $model = \Helpers\FormInputHandler::getPostVariable('model');
              $description = \Helpers\FormInputHandler::getPostVariable('description');
              $price = \Helpers\FormInputHandler::getPostVariable('price');
              $categoryID = '';
              $gender = '';
              $frameMaterialOptionID = '';
              $frameStyleOptionID = '';
              $frameShapeOptionID = '';
              $frameNosePadsOptionID = '';
              if (isset($data) && $data['data']) {
                if (isset($data['data']['frame']) && count($data['data']['frame']) > 0) {
                  $details = $data['data']['frame']['details'];
                  $images = $data['data']['frame']['images'];
                  $options = $data['data']['frame']['options'];
                  $frameID = $details['frame_ID'];
                  $categoryID = $details['category_ID'];
                  $model = $details['model'];
                  $description = $details['description'];
                  $gender = $details['gender'];
                  $price = $details['price'];
                  $frameMaterialOptionID = $details['frameMaterialOption_ID'];
                  $frameStyleOptionID = $details['frameStyleOption_ID'];
                  $frameShapeOptionID = $details['frameShapeOption_ID'];
                  $frameNosePadsOptionID = $details['frameNosePadsOption_ID'];
                  $createDate = $details['create_date'];
                  $updateDate = $details['update_date'];
                }
                if (isset($data['data']['categoriesName']) && count($data['data']['categoriesName']) > 0) {
                  $categories = $data['data']['categoriesName'];
                }
                if (isset($data['data']['frameStyleOptions']) && count($data['data']['frameStyleOptions']) > 0) {
                  $frameStyleOptions = $data['data']['frameStyleOptions'];
                }
                if (isset($data['data']['frameShapeOptions']) && count($data['data']['frameShapeOptions']) > 0) {
                  $frameShapeOptions = $data['data']['frameShapeOptions'];
                }
                if (isset($data['data']['frameMaterialOptions']) && count($data['data']['frameMaterialOptions']) > 0) {
                  $frameMaterialOptions = $data['data']['frameMaterialOptions'];
                }
                if (isset($data['data']['frameNosePadsOptions']) && count($data['data']['frameNosePadsOptions']) > 0) {
                  $frameNosePadsOptions = $data['data']['frameNosePadsOptions'];
                }
              }
            ?>
            <!-- Start Form -->
            <form action="" method="post"  enctype="multipart/form-data" class="w-[940px] p-20 flex flex-col gap-10 items-center justify-center max-sm:p-3 max-sm:w-full">

              <!-- Start Images -->
              <div class="w-full flex flex-row items-center justify-center flex-wrap gap-3">
                <!-- Main Image -->
                <div class="w-96 h-96">
                  <img class="w-full h-full object-contain border-2 border-light-gray hover:border-slate-gray duration-150 ease-in-out cursor-pointer" src="<?= \Helpers\URLHelper::appendToBaseURL(((isset($images[0]['image_url'])) ? 'public/uploads/images/' . $images[0]['image_url']: '/public/assets/images/desk-office-with-objects.jpg')) ?>" alt="" id="main-image">
                </div>

                <!-- Start Input Files -->
                <div class="w-96 h-96 flex flex-row flex-wrap" id="images-container">
                  <label for="first-image" class="overflow-hidden relative w-1/2 h-1/2 flex flex-col items-center justify-center border-2 border-light-gray hover:border-slate-gray duration-150 ease-in-out cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Upload a file</span>
                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                    <input id="first-image" type="file" name="images[]" class="hidden">
                    <?php if(isset($images[0]['frameImage_ID'])): ?>
                      <input type="hidden" name="imageID[]" value="<?= $images[0]['frameImage_ID'] ?>">
                    <?php endif; ?>
                    <img class="absolute object-contain" src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . ((isset($images[0]['image_url'])) ? $images[0]['image_url']: '')) ?>" alt="">
                  </label>
                  <label for="second-image" class="overflow-hidden relative w-1/2 h-1/2 flex flex-col items-center justify-center border-2 border-light-gray hover:border-slate-gray duration-150 ease-in-out cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Upload a file</span>
                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                    <input id="second-image" type="file" name="images[]" class="hidden">
                    <?php if(isset($images[1]['frameImage_ID'])): ?>
                      <input type="hidden" name="imageID[]" value="<?= $images[1]['frameImage_ID'] ?>">
                    <?php endif; ?>
                    <img class="absolute object-contain" src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . ((isset($images[1]['image_url'])) ? $images[1]['image_url']: '')) ?>" alt="">
                  </label>
                  <label for="third-image" class="overflow-hidden relative w-1/2 h-1/2 flex flex-col items-center justify-center border-2 border-light-gray hover:border-slate-gray duration-150 ease-in-out cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Upload a file</span>
                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                    <input id="third-image" type="file" name="images[]" class="hidden">
                    <?php if(isset($images[2]['frameImage_ID'])): ?>
                      <input type="hidden" name="imageID[]" value="<?= $images[2]['frameImage_ID'] ?>">
                    <?php endif; ?>
                    <img class="absolute object-contain" src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . ((isset($images[2]['image_url'])) ? $images[2]['image_url']: '')) ?>" alt="">
                  </label>
                  <label for="fourth-image" class="overflow-hidden relative w-1/2 h-1/2 flex flex-col items-center justify-center border-2 border-light-gray hover:border-slate-gray duration-150 ease-in-out cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Upload a file</span>
                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                    <input id="fourth-image" type="file" name="images[]" class="hidden">
                    <?php if(isset($images[3]['frameImage_ID'])): ?>
                      <input type="hidden" name="imageID[]" value="<?= $images[3]['frameImage_ID'] ?>">
                    <?php endif; ?>
                    <img class="absolute object-contain" src="<?= \Helpers\URLHelper::appendToBaseURL('public/uploads/images/' . ((isset($images[3]['image_url'])) ? $images[3]['image_url']: '')) ?>" alt="">
                  </label>
                </div>
                <!-- End Input Files -->
                <!-- Link Edit Image -->
                <p class="text-sm leading-6 text-gray-600">Please use the following <a class="underline capitalize text-blue" target="_blank" href="https://redketchup.io/image-resizer">link</a> to adjust the size of the images.</p>
              </div>
              <!-- End Imgaes -->
              
              <!-- Start Input Fields -->
              <div class="w-full h-fit flex flex-row flex-wrap items-start gap-3 max-md:gap-6">
                <!-- Model -->
                <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                  <label class="text-xl font-thin capitalize" for="model">model</label>
                  <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="text" name="model" value="<?= $model ?>" id="model" placeholder="example">
                </div>

                <!-- Category -->
                <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                  <label class="text-xl font-thin capitalize" for="category">category</label>
                  <select name="category" id="category" class="appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-300">
                    <option value="">-- select model category --</option>
                    <?php foreach ($categories as $key => $category): ?>
                        <option value="<?= $category['category_ID'] ?>" <?= (! empty($categoryID)) ? (($categoryID == $category['category_ID']) ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('category', $category['category_ID']) ?>><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <!-- price -->
                <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                  <label class="text-xl font-thin capitalize" for="price">price</label>
                  <input class="focus:border-cerulean-depths outline-none h-12 border-2 rounded-md px-3 ease-in-out duration-150" type="number" name="price" value="<?= $price ?>" id="price">
                </div>

                <!-- gender -->
                <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                  <label class="text-xl font-thin capitalize" for="gender">gender</label>
                  <select name="gender" id="gender" class="appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-300">
                    <option value="">-- select your gender --</option>
                    <option value="male"   <?= (! empty($gender)) ? (($gender == 'male') ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('gender', 'male') ?>>male</option>
                    <option value="female" <?= (! empty($gender)) ? (($gender == 'female') ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('gender', 'female') ?>>female</option>
                    <option value="unisex" <?= (! empty($gender)) ? (($gender == 'unisex') ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('gender', 'unisex') ?>>unisex</option>
                  </select>
                </div>


                <!-- description -->
                <div class="w-full flex flex-col flex-none max-sm:w-full">
                  <label class="text-xl font-thin capitalize" for="description">description</label>
                  <textarea name="description" id="description" class="focus:border-cerulean-depths outline-none w-full h-20 border-2 rounded-md px-3 ease-in-out duration-150"><?= $description ?></textarea>
                  <p class="text-sm leading-6 text-gray-600">Write a few sentences about this frame.</p>
                </div>


                <!-- Frame material -->
                <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                  <label class="text-xl font-thin capitalize" for="frameMaterial">frame material</label>
                  <select name="frameMaterial" id="frameMaterial" class="appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-300">
                    <option value="">-- select frame material --</option>
                    <?php foreach ($frameMaterialOptions as $key => $frameMaterialOption): ?>
                        <option value="<?= $frameMaterialOption['frameMaterialOption_ID'] ?>" <?= (! empty($frameMaterialOptionID)) ? (($frameMaterialOptionID == $frameMaterialOption['frameMaterialOption_ID']) ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('frameMaterial', $frameMaterialOption['frameMaterialOption_ID']) ?>><?= $frameMaterialOption['frame_material'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <!-- Frame Style -->
                <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                  <label class="text-xl font-thin capitalize" for="frameStyle">Frame Style</label>
                  <select name="frameStyle" id="frameStyle" class="appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-300">
                    <option value="">-- select Frame Style --</option>
                    <?php foreach ($frameStyleOptions as $key => $frameStyleOption): ?>
                        <option value="<?= $frameStyleOption['frameStyleOption_ID'] ?>" <?= (! empty($frameStyleOptionID)) ? (($frameStyleOptionID == $frameStyleOption['frameStyleOption_ID']) ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('frameStyle', $frameStyleOption['frameStyleOption_ID']) ?>><?= $frameStyleOption['frame_style'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <!-- Frame Shape -->
                <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                  <label class="text-xl font-thin capitalize" for="frameShape">Frame Shape</label>
                  <select name="frameShape" id="frameShape" class="appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-300">
                    <option value="">-- select Frame Shape --</option>
                    <?php foreach ($frameShapeOptions as $key => $frameShapeOption): ?>
                        <option value="<?= $frameShapeOption['frameShapeOption_ID'] ?>" <?= (! empty($frameShapeOptionID)) ? (($frameShapeOptionID == $frameShapeOption['frameShapeOption_ID']) ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('frameShape', $frameShapeOption['frameShapeOption_ID']) ?>><?= $frameShapeOption['frame_shape'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <!-- Nose Pads -->
                <div class="w-96 flex flex-col flex-none max-lg:w-80 max-md:w-full">
                  <label class="text-xl font-thin capitalize" for="nosePads">Nose Pads</label>
                  <select name="nosePads" id="nosePads" class="appearance-none border-2 rounded-lg px-3 py-2 focus:outline-none focus:border-sky-breeze-blue transition ease-in-out duration-300">
                    <option value="">-- select Nose Pads --</option>
                    <?php foreach ($frameNosePadsOptions as $key => $frameNosePadsOption): ?>
                        <option value="<?= $frameNosePadsOption['frameNosePadsOption_ID'] ?>" <?= (! empty($frameNosePadsOptionID)) ? (($frameNosePadsOptionID == $frameNosePadsOption['frameNosePadsOption_ID']) ? 'selected': ''): \Helpers\FormInputHandler::getSelectedStatus('nosePads', $frameNosePadsOption['frameNosePadsOption_ID']) ?>><?= $frameNosePadsOption['frame_nose_pads'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <!-- Start colors, size and quantity -->
                <div id="product-options-container" class="mt-10 flex flex-col gap-5">
                  <!-- Name Of Section -->
                  <h2 class="font-medium text-2xl capitalize">colors, size and quantity</h2>

                  <!-- Start div(color & quantity) & div(Frame Width & Bridge Width & Temple Length) -->

                  <?php if(count($options) > 0): foreach($options as $key => $frameOption): ?>
                    
                    <div class="pb-5 w-fit border-b-2 flex flex-col gap-5 items-start justify-center">

                      <input type="hidden" name="oldOptions[<?= $key ?>][frameOptionID]" value="<?= $frameOption['frameOption_ID'] ?>">

                      <!-- Start div(color & quantity) -->
                      <div class="flex flex-row flex-wrap justify-start gap-5">
                        <label class="w-96 flex flex-row flex-none gap-5 items-center max-lg:w-80 max-md:w-full">
                          <span class="text-xl font-thin capitalize">color</span>
                          <input class="w-40 h-10 outline-none border-2 rounded-md overflow-hidden cursor-pointer" type="color" name="oldOptions[<?= $key ?>][color]" value="<?= (isset($frameOption['color'])) ? $frameOption['color']:'#000000' ?>">
                        </label>
                        <label class="w-96 flex flex-row flex-none gap-5 items-center max-lg:w-80 max-md:w-full">
                          <span class="text-xl font-thin capitalize">quantity</span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="oldOptions[<?= $key ?>][quantity]" type="number" value="<?= (isset($frameOption['quantity'])) ? $frameOption['quantity']:'1' ?>">
                        </label>
                      </div>
                      <!-- End div(color & quantity) -->

                      <!-- Start div(Frame Width & Bridge Width & Temple Length) -->
                      <div class="flex flex-row flex-wrap items-start justify-start gap-10">
                        <!-- Frame Width -->
                        <label class="w-fit flex flex-col flex-none gap-2">
                          <span class="text-xl font-thin capitalize">Frame Width <span class="normal-case">(mm)</span></span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="oldOptions[<?= $key ?>][frameWidth]" type="number" value="<?= (isset($frameOption['frame_width'])) ? $frameOption['frame_width']: '150' ?>">
                        </label>

                        <!-- Bridge Width -->
                        <label class="w-fit flex flex-col flex-none gap-2">
                          <span class="text-xl font-thin capitalize">Bridge Width <span class="normal-case">(mm)</span></span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="oldOptions[<?= $key ?>][bridgeWidth]" type="number" value="<?= (isset($frameOption['bridge_width'])) ? $frameOption['bridge_width']:'20' ?>">
                        </label>

                        <!-- Temple Length -->
                        <label class="w-fit flex flex-col flex-none gap-2">
                          <span class="text-xl font-thin capitalize">Temple Length <span class="normal-case">(mm)</span></span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="oldOptions[<?= $key ?>][templeLength]" type="number" value="<?= (isset($frameOption['temple_length'])) ? $frameOption['temple_length']:'140' ?>">
                        </label>
                      </div>
                      <!-- End div(Frame Width & Bridge Width & Temple Length) -->

                      <!-- Delete Option Button -->
                      <a href="<?= \Helpers\URLHelper::appendToBaseURL('products/deleteProductOption/' . $frameID . '/' . $frameOption['frameOption_ID']) ?>" class="flex items-center justify-center w-64 h-10 font-bold text-lg capitalize text-red border-2 hover:border-solid-red ease-in-out duration-150 rounded-lg">Delete this option</a>
                    </div>
                  <?php endforeach; endif; ?>

                  <?php if(isset($_POST['FrameOptions'])): foreach($_POST['FrameOptions'] as $key => $frameOption): ?>
                    <div id="product-options" class="pb-5 w-fit border-b-2 flex flex-col gap-5 items-start justify-center">

                      <!-- Start div(color & quantity) -->
                      <div class="flex flex-row flex-wrap justify-start gap-5">
                        <label class="w-96 flex flex-row flex-none gap-5 items-center max-lg:w-80 max-md:w-full">
                          <span class="text-xl font-thin capitalize">color</span>
                          <input class="w-40 h-10 outline-none border-2 rounded-md overflow-hidden cursor-pointer" type="color" name="color[]" value="<?= (isset($frameOption[":color_$key"])) ? $frameOption[":color_$key"] : '#000000' ?>">
                        </label>
                        <label class="w-96 flex flex-row flex-none gap-5 items-center max-lg:w-80 max-md:w-full">
                          <span class="text-xl font-thin capitalize">quantity</span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="quantity[]" type="number" value="<?= (isset($frameOption[":quantity_$key"])) ? $frameOption[":quantity_$key"] : '1' ?>">
                        </label>
                      </div>
                      <!-- End div(color & quantity) -->

                      <!-- Start div(Frame Width & Bridge Width & Temple Length) -->
                      <div class="flex flex-row flex-wrap items-start justify-start gap-10">
                        <!-- Frame Width -->
                        <label class="w-fit flex flex-col flex-none gap-2">
                          <span class="text-xl font-thin capitalize">Frame Width <span class="normal-case">(mm)</span></span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="frameWidth[]" type="number" value="<?= (isset($frameOption[":frameWidth_$key"])) ? $frameOption[":frameWidth_$key"] : '150' ?>">
                        </label>

                        <!-- Bridge Width -->
                        <label class="w-fit flex flex-col flex-none gap-2">
                          <span class="text-xl font-thin capitalize">Bridge Width <span class="normal-case">(mm)</span></span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="bridgeWidth[]" type="number" value="<?= (isset($frameOption[":bridgeWidth_$key"])) ? $frameOption[":bridgeWidth_$key"] : '20' ?>">
                        </label>

                        <!-- Temple Length -->
                        <label class="w-fit flex flex-col flex-none gap-2">
                          <span class="text-xl font-thin capitalize">Temple Length <span class="normal-case">(mm)</span></span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="templeLength[]" type="number" value="<?= (isset($frameOption[":templeLength_$key"])) ? $frameOption[":templeLength_$key"] : '140' ?>">
                        </label>
                      </div>
                      <!-- End div(Frame Width & Bridge Width & Temple Length) -->

                      <!-- Delete Option Button -->
                      <button type="button" class="delete-option-btn w-64 h-10 font-bold text-lg capitalize text-red border-2 hover:border-solid-red ease-in-out duration-150 rounded-lg">Delete this option</button>
                    </div>
                  <?php endforeach; ?>
                  <?php else: ?>
                    <?php if(count($options) == 0): ?>
                    <div id="product-options" class="pb-5 w-fit border-b-2 flex flex-col gap-5 items-start justify-center">
        
                      <!-- Start div(color & quantity) -->
                      <div class="flex flex-row flex-wrap justify-start gap-5">
                        <label class="w-96 flex flex-row flex-none gap-5 items-center max-lg:w-80 max-md:w-full">
                          <span class="text-xl font-thin capitalize">color</span>
                          <input class="w-40 h-10 outline-none border-2 rounded-md overflow-hidden cursor-pointer" type="color" name="color[]" value="#000000">
                        </label>
                        <label class="w-96 flex flex-row flex-none gap-5 items-center max-lg:w-80 max-md:w-full">
                          <span class="text-xl font-thin capitalize">quantity</span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="quantity[]" type="number" value="1">
                        </label>
                      </div>
                      <!-- End div(color & quantity) -->
        
                      <!-- Start div(Frame Width & Bridge Width & Temple Length) -->
                      <div class="flex flex-row flex-wrap items-start justify-start gap-10">
                        <!-- Frame Width -->
                        <label class="w-fit flex flex-col flex-none gap-2">
                          <span class="text-xl font-thin capitalize">Frame Width <span class="normal-case">(mm)</span></span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="frameWidth[]" type="number" value="150">
                        </label>
          
                        <!-- Bridge Width -->
                        <label class="w-fit flex flex-col flex-none gap-2">
                          <span class="text-xl font-thin capitalize">Bridge Width <span class="normal-case">(mm)</span></span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="bridgeWidth[]" type="number" value="20">
                        </label>
          
                        <!-- Temple Length -->
                        <label class="w-fit flex flex-col flex-none gap-2">
                          <span class="text-xl font-thin capitalize">Temple Length <span class="normal-case">(mm)</span></span>
                          <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="templeLength[]" type="number" value="140">
                        </label>
                      </div>
                      <!-- End div(Frame Width & Bridge Width & Temple Length) -->
        
                      <!-- Delete Option Button -->
                      <button type="button" class="delete-option-btn w-64 h-10 font-bold text-lg capitalize text-red border-2 hover:border-solid-red ease-in-out duration-150 rounded-lg">Delete this option</button>
                    </div>
                    <?php endif ;?>
                  <?php endif; ?>
                  <!-- End div(color & quantity) & div(Frame Width & Bridge Width & Temple Length) -->
                </div>
                <!-- End colors, size and quantity -->

                <!-- Button Add More Colors, size, quantity -->
                <button id="add-more" type="button" class="w-80 h-10 font-bold text-lg capitalize text-blue border-2 hover:border-blue ease-in-out duration-150 rounded-lg">add more colors, size and quantity</button>
              </div>

              <!-- Submit Button -->
              <button class="w-64 max-sm:w-full h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold" type="submit">Add Product</button>

              <!-- Rest Button -->
              <button class="w-64 max-sm:w-full h-12 rounded-md text-xl capitalize bg-cerulean-depths hover:bg-midnight-sapphire text-white ease-in-out duration-150 font-bold" type="reset">Reset</button>
            </form>
            <!-- End Form -->
          </div>
        </section>

        </div>
    </main>

    <script>
        // Start Add More Inputs
        document.addEventListener("DOMContentLoaded", function() {
          const options = document.getElementById("product-options-container");
          const productOptions = document.getElementById("product-options");
          const addMoreBtn = document.getElementById("add-more");
          let newProductOptions;

          document.addEventListener('click', function (event) {
            if (event.target && event.target.classList.contains('delete-option-btn')) {
                const optionDiv = event.target.closest('#product-options');
                const productOptionsContainer = document.getElementById('product-options-container');
                const productOptionsDivs = productOptionsContainer.querySelectorAll('#product-options');
                      
                if (optionDiv && productOptionsDivs.length > 1) {
                  optionDiv.remove();
                }
            }
          });
          
          addMoreBtn.addEventListener("click", () => {
            if (productOptions == null) {
              newProductOptions = document.createElement('div');
              newProductOptions.className = 'product-options pb-5 w-fit border-b-2 flex flex-col gap-5 items-start justify-center';
              newProductOptions.innerHTML = `
                <div class="flex flex-row flex-wrap justify-start gap-5">
                  <label class="w-96 flex flex-row flex-none gap-5 items-center max-lg:w-80 max-md:w-full">
                    <span class="text-xl font-thin capitalize">color</span>
                    <input class="w-40 h-10 outline-none border-2 rounded-md overflow-hidden cursor-pointer" type="color" name="color[]" value="#000000">
                  </label>
                  <label class="w-96 flex flex-row flex-none gap-5 items-center max-lg:w-80 max-md:w-full">
                    <span class="text-xl font-thin capitalize">quantity</span>
                    <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="quantity[]" type="number" value="1">
                  </label>
                </div>
                <div class="flex flex-row flex-wrap items-start justify-start gap-10">
                  <!-- Frame Width -->
                  <label class="w-fit flex flex-col flex-none gap-2">
                    <span class="text-xl font-thin capitalize">Frame Width <span class="normal-case">(mm)</span></span>
                    <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="frameWidth[]" type="number" value="150">
                  </label>

                  <!-- Bridge Width -->
                  <label class="w-fit flex flex-col flex-none gap-2">
                    <span class="text-xl font-thin capitalize">Bridge Width <span class="normal-case">(mm)</span></span>
                    <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="bridgeWidth[]" type="number" value="20">
                  </label>

                  <!-- Temple Length -->
                  <label class="w-fit flex flex-col flex-none gap-2">
                    <span class="text-xl font-thin capitalize">Temple Length <span class="normal-case">(mm)</span></span>
                    <input class="w-28 h-12 text-center border-2 border-light-gray rounded-md focus:outline-none text-lg" name="templeLength[]" type="number" value="140">
                  </label>
                </div>
                <button type="button" class="delete-option-btn w-64 h-10 font-bold text-lg capitalize text-red border-2 hover:border-solid-red ease-in-out duration-150 rounded-lg">Delete this option</button>`;
            }
            else {
              newProductOptions = productOptions.cloneNode(true);
            }

            options.appendChild(newProductOptions);
          });
        });

        const mainImage = document.querySelector("#main-image");
        const imagesInput = Array.from(document.querySelectorAll("#images-container input"));
        const images = Array.from(document.querySelectorAll("#images-container img"));
        imagesInput.forEach(input => {
          input.addEventListener("change", () => {
            let index = imagesInput.indexOf(input);
            let src = URL.createObjectURL(input.files[0]);
            images[index].src = src;
            if (index == 0) {
              mainImage.src = src;
            }
          });
        });
    </script>

<?php
require_once INCLUDES . 'elements.php';
require_once INCLUDES . 'errors.php';
require_once INCLUDES . 'end.body.php';
?>