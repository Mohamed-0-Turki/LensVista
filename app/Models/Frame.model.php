<?php

namespace Models;

use Core\Database;
use Core\Model;
use Helpers\FormInputHandler;
use Helpers\RandomString;

class Frame extends FrameValidation {

  private int $numberOfImages = 4;

  public function fetchNumberOfFrames() : int {
    return Model::table('frames')->count();
  }

  public function fetchAverageRate(string $frameID = '') : float {
    $query = "SELECT (SUM(`evaluation`) / COUNT(*)) AS `avg_rate` FROM `framesEvaluation` WHERE `frame_ID` = :frameID;";
    $data = Database::executeQuery($query, [':frameID' => $frameID]);
    if (count($data) > 0) {
      if ($data[0]['avg_rate'] != null) {
        return $data[0]['avg_rate'];
      }
    }
    return 0;
  }

  public function fetchFrames(string $model = ''): array {
    $params = [];
    $query = "SELECT 
                    `frames`.`frame_ID`,
                    `frames`.`model`,
                    `frames`.`price`,
                    MAX(IF(`frameOptions`.`quantity` > 0, 1, 0)) AS `status`,
                    GROUP_CONCAT(DISTINCT `frameOptions`.`color` ORDER BY `frameOptions`.`frameOption_ID` ASC) AS `colors`,
                    `frameImages`.`image_url`
                FROM `frames` 
          INNER JOIN `frameOptions` AS `mainOptions`
                  ON `mainOptions`.`frame_ID` = `frames`.`frame_ID`
                  AND `mainOptions`.`main_option` = 1
          INNER JOIN `frameOptions` 
                  ON `frameOptions`.`frame_ID` = `frames`.`frame_ID`
          INNER JOIN `frameImages` 
                  ON `frameImages`.`frame_ID` = `frames`.`frame_ID` 
                WHERE `frameImages`.`main_image` = 1 ";
    if (! empty($model)) {
      $query .= "AND `frames`.`model` LIKE :model ";
      $model = $model . '%';
      $params = [':model' => $model];
    }
    $query .= "GROUP BY `frames`.`frame_ID`, `frames`.`model`, `frames`.`price`, `mainOptions`.`color`, `frameImages`.`image_url`;";
    $data = Database::executeQuery($query, $params);
    foreach ($data as $key => $row) {
        $data[$key]['colors'] = explode(',', $row['colors']);
    }
    return $data;
  }
  public function fetchFramesByCategory(string $categoryID = ''): array {
    $data = Database::executeQuery("SELECT 
                                          `frames`.`frame_ID`,
                                          `frames`.`model`,
                                          `frames`.`price`,
                                          MAX(IF(`frameOptions`.`quantity` > 0, 1, 0)) AS `status`,
                                          GROUP_CONCAT(DISTINCT `frameOptions`.`color` ORDER BY `frameOptions`.`frameOption_ID` ASC) AS `colors`,
                                          `frameImages`.`image_url`
                                      FROM `frames` 
                                INNER JOIN `frameOptions` AS `mainOptions`
                                        ON `mainOptions`.`frame_ID` = `frames`.`frame_ID`
                                        AND `mainOptions`.`main_option` = 1
                                INNER JOIN `frameOptions` 
                                        ON `frameOptions`.`frame_ID` = `frames`.`frame_ID`
                                INNER JOIN `frameImages` 
                                        ON `frameImages`.`frame_ID` = `frames`.`frame_ID` 
                                      WHERE `frames`.`category_ID` = :category_ID AND `frameImages`.`main_image` = 1
                                  GROUP BY `frames`.`frame_ID`, `frames`.`model`, `frames`.`price`, `mainOptions`.`color`, `frameImages`.`image_url`;"
        ,[':category_ID' => FormInputHandler::sanitizeInput($categoryID)]);
    foreach ($data as $key => $row) {
        $data[$key]['colors'] = explode(',', $row['colors']);
    }
    return $data;
  }
  public function fetchProductsByModel(string $model = ''): array {
    $query = "SELECT
                    `frames`.`frame_ID`,
                    `frames`.`model`,
                    `frames`.`description`,
                    `frameImages`.`image_url`
                FROM
                    `frames`
                INNER JOIN `frameImages` ON `frameImages`.`frame_ID` = `frames`.`frame_ID`
                WHERE `frameImages`.`main_image` = 1 AND `frames`.`model` LIKE :model";
    $model = $model . '%';
    return Database::executeQuery($query, [':model' => $model]);
  }
  public function fetchFrameByID(string $productID = '', string $userID = ''): array {
    $data = [];
    $query = "SELECT 
                    `frames`.`frame_ID`, 
                    `frames`.`model`, 
                    `frames`.`price`, 
                    `frames`.`gender`,
                    `frames`.`description`, 
                    `frameMaterialOptions`.`frame_material`, 
                    `frameStyleOptions`.`frame_style`, 
                    `frameShapeOptions`.`frame_shape`, 
                    `frameNosePadsOptions`.`frame_nose_pads`, 
                    GROUP_CONCAT(DISTINCT `frameImages`.`image_url` ORDER BY `frameImages`.`main_image` DESC) AS `images`, 
                    GROUP_CONCAT(DISTINCT `frameOptions`.`color` ORDER BY `frameOptions`.`quantity` DESC) AS `colors`
                FROM 
                    `frames` 
          INNER JOIN 
                    `frameMaterialOptions` 
                  ON `frameMaterialOptions`.`frameMaterialOption_ID` = `frames`.`frameMaterialOption_ID`
          INNER JOIN 
                    `frameStyleOptions` 
                  ON `frameStyleOptions`.`frameStyleOption_ID` = `frames`.`frameStyleOption_ID`
          INNER JOIN 
                    `frameShapeOptions` 
                  ON `frameShapeOptions`.`frameShapeOption_ID` = `frames`.`frameShapeOption_ID`
          INNER JOIN 
                    `frameNosePadsOptions` 
                  ON `frameNosePadsOptions`.`frameNosePadsOption_ID` = `frames`.`frameNosePadsOption_ID`
          INNER JOIN 
                    `frameOptions` 
                  ON `frameOptions`.`frame_ID` = `frames`.`frame_ID`
          INNER JOIN 
                    `frameImages` 
                  ON `frameImages`.`frame_ID` = `frames`.`frame_ID` 
                WHERE `frames`.`frame_ID` = :product_ID
            GROUP BY 
                    `frames`.`frame_ID`, 
                    `frames`.`model`, 
                    `frames`.`price`, 
                    `frames`.`gender`, 
                    `frames`.`description`,
                    `frameMaterialOptions`.`frame_material`, 
                    `frameStyleOptions`.`frame_style`, 
                    `frameShapeOptions`.`frame_shape`, 
                    `frameNosePadsOptions`.`frame_nose_pads`;";

    $productData = Database::executeQuery($query, [':product_ID' => $productID]);
    if (count($productData) != 0) {
        $productData[0]['images'] = explode(",", $productData[0]['images']);
        $productData[0]['colors'] = explode(",", $productData[0]['colors']);
        if (! empty($userID)) {
            $query = "SELECT 
                        CASE 
                            WHEN EXISTS (
                                SELECT 1 
                                FROM `wishlistItems` 
                                WHERE `wishlistItems`.`user_ID` = :user_ID 
                                  AND `wishlistItems`.`frame_ID` = :product_ID
                            ) 
                        THEN 1 
                        ELSE 0 
                        END AS `is_wishlisted`;";
            $isWishlists = Database::executeQuery($query, [':product_ID' => $productID, ':user_ID' => $userID]);
            $data = array_merge($productData[0], $isWishlists[0]);
        }
        else {
            $data = $productData[0];
        }
    }
    return $data;
  }

  public function fetchFrameOptionsByColor(string $productID = '', string $productColor = '', array $data = []): array {
    $query = "SELECT
                    `frameOptions`.`frameOption_ID`,
                    `frameOptions`.`quantity`,
                    `frameOptions`.`frame_width`,
                    `frameOptions`.`bridge_width`,
                    `frameOptions`.`temple_length`
                FROM 
                    `frameOptions`
                WHERE
                    `frameOptions`.`frame_ID` = :frame_ID
                    AND `frameOptions`.`color` = :frame_color";
    $data['options'] = Database::executeQuery($query, [':frame_ID' => $productID, ':frame_color' => $productColor]);
    return $data;
  }

  public function fetchFrameDetails(string $sort ='DESC') : array {
    $query = "SELECT 
                    `frames`.`frame_ID`, 
                    `frames`.`model`, 
                    `frames`.`price`, 
                    `frames`.`gender`, 
                    `frameMaterialOptions`.`frame_material`, 
                    `frameStyleOptions`.`frame_style`, 
                    `frameShapeOptions`.`frame_shape`, 
                    `frameNosePadsOptions`.`frame_nose_pads`, 
                    `categories`.`name` AS `category_name` 
                FROM 
                    `frames` 
          INNER JOIN 
                    `categories` 
                  ON `categories`.`category_ID` = `frames`.`category_ID` 
          INNER JOIN 
                    `frameMaterialOptions` 
                  ON `frameMaterialOptions`.`frameMaterialOption_ID` = `frames`.`frameMaterialOption_ID` 
          INNER JOIN 
                    `frameStyleOptions` 
                  ON `frameStyleOptions`.`frameStyleOption_ID` = `frames`.`frameStyleOption_ID`
          INNER JOIN 
                    `frameShapeOptions` 
                  ON `frameShapeOptions`.`frameShapeOption_ID` = `frames`.`frameShapeOption_ID`
          INNER JOIN 
                    `frameNosePadsOptions` 
                  ON `frameNosePadsOptions`.`frameNosePadsOption_ID` = `frames`.`frameNosePadsOption_ID`
            ORDER BY `frames`.`create_date` $sort;";
    return Database::executeQuery($query);
  }

  public function fetchFrameImages(string $frameID = '') : array {
    return Model::table('frameImages')->select('frameImage_ID', 'frame_ID', 'image_url')->where('frame_ID', $frameID)->orderBy('main_image', 'DESC')->get();
  }

  public function fetchAllDetailsAboutFrame(string $frameID = '') : array {
    $query = "SELECT `frame_ID`, `category_ID`, `model`, `price`, `gender`, `description`, `frameMaterialOption_ID`, `frameStyleOption_ID`, `frameShapeOption_ID`, `frameNosePadsOption_ID`, `create_date`, `update_date` FROM `frames` WHERE `frame_ID` = :frameID;
              SELECT `frameImage_ID`, `main_image`, `image_url` FROM `frameImages` WHERE `frame_ID` = :frameID;
              SELECT `frameOption_ID`, `main_option`, `color`, `quantity`, `frame_width`, `bridge_width`, `temple_length` FROM `frameOptions` WHERE `frame_ID` = :frameID";
    $data = Database::executeQuery($query, [':frameID' => $frameID]);
    if (count($data) > 0 && count($data[0]) > 0) {
      $data = [
        'details' => $data[0][0],
        'images' => $data[1],
        'options' => $data[2],
      ];
    }
    else {
      $data = [];
    }
    return $data;
  }

  public function getNumberOfFrameImages() : int {
    return $this->numberOfImages;
  }
  public function fetchFrameStyles() : array {
    return Model::table('frameStyleOptions')->select('frameStyleOption_ID', 'frame_style')->get();
  }

  public function fetchFrameShapes() : array {
    return Model::table('frameShapeOptions')->select('frameShapeOption_ID', 'frame_shape')->get();
  }

  public function fetchFrameMaterials() : array {
    return Model::table('frameMaterialOptions')->select('frameMaterialOption_ID', 'frame_material')->get();
  }

  public function fetchFrameNosePads() : array {
    return Model::table('frameNosePadsOptions')->select('frameNosePadsOption_ID', 'frame_nose_pads')->get();
  }

  public function generateFrameOptions(array $colors, array $quantities, array $frameWidths, array $bridgeWidths, array $templeLengths): array
  {
      $frameOptions = [];
      $numberOfOptions = count($colors);
      for ($i = 0; $i < $numberOfOptions; $i++) {
          $frameOptions[$i] = [
              ":color_$i" => $colors[$i],
              ":quantity_$i" => $quantities[$i],
              ":frameWidth_$i" => $frameWidths[$i],
              ":bridgeWidth_$i" => $bridgeWidths[$i],
              ":templeLength_$i" => $templeLengths[$i],
          ];
          if ($i == 0) {
              $frameOptions[$i][":mainOption_$i"] = 1; 
          }
          else {
              $frameOptions[$i][":mainOption_$i"] = 0; 
          }
      }
      return $frameOptions;
  }

  public function processFrameImages(array $images = []): array
  {
      $frameImages = [];
      for ($i = 0; $i < $this->numberOfImages; $i++) {
        $frameImages[$i] = [
            'name' => $images['name'][$i],
            'full_path' => $images['full_path'][$i],
            'type' => $images['type'][$i],
            'tmp_name' => $images['tmp_name'][$i],
            'error' => $images['error'][$i],
            'size' => $images['size'][$i],
        ];
      }
      return $frameImages;
  }
  public function generateFrameImageNames(array $images = []) : array {
    $imagesName = [];
    foreach ($images as $key => $image) {
        $fileExtension  = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageName = RandomString::generateAlphanumericString(100) . '.' . $fileExtension;
        $imagesName[":imageName_$key"] = $imageName;
        if (isset($image['frameImageID'])) {
          $imagesName[":frameImageID_$key"] = $image['frameImageID'];
        }
        else {
          if ($key == 0) {
              $imagesName[":mainImage_$key"] = 1; 
          }
          else {
              $imagesName[":mainImage_$key"] = 0; 
          }
        }
    }
    return $imagesName;
  }
}