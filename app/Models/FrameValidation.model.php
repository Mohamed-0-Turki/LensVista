<?php

namespace Models;

use Core\Model;
use Helpers\FormInputHandler;
use Helpers\StringValidator;
use Helpers\FileUploadValidator;

class FrameValidation {

    public function validateFrame(Frame $frame) : array {
        return array_merge(
            
        );
    }

    public function validateFrameImage(array $file = []): array
    {
        $errors = [];
        if (! FileUploadValidator::validateExtension($file['name'], ['jpeg', 'jpg', 'png'])) {
            $errors[] = 'Invalid file extension.';
        }
        elseif (! FileUploadValidator::validateType($file['type'], ['image/jpeg', 'image/png', 'image/jpg'])) {
            $errors[] = 'Invalid file type.';
        }
        elseif (! FileUploadValidator::validateErrors($file['error'])) {
            $errors = 'File upload error';
        }
        elseif (! FileUploadValidator::validateSize($file['size'], 5242880)) {
            $errors[] = 'File size must be less than 5MB.';
        }
        return $errors;
    }

    public function validateModelName(string $model = ''): array
    {
        $errors = [];
        if (!StringValidator::isLengthValid($model, 3, 50)) {
            $errors[] = 'Model name must be between 3 and 50 characters';
        }
        return $errors;
    }

    public function validatePrice(float $price = 0.0): array
    {
        $errors = [];
        if ($price <= 0) {
            $errors[] = 'Price must be a positive number.';
        }
        return $errors;
    }

    public function validateGender(string $gender = ''): array
    {
        $errors = [];
        if (!in_array($gender, ['male', 'female', 'unisex'])) {
            $errors[] = 'Invalid gender. Please choose either "male" or "female" or "unisex".';
        }
        return $errors;
    }

    public function validateDescription(string $description = ''): array
    {
        $errors = [];
        if (!StringValidator::isLengthValid($description, 10, 1000)) {
            $errors[] = 'Description must be between 10 and 1000 characters.';
        }
        return $errors;
    }

    public function validateFrameStyleID(string|int $id): array {
      $errors = [];
      $result = Model::table('frameStyleOptions')->select('frameStyleOption_ID')->where('frameStyleOption_ID', $id)->get();
      if (empty($result)) {
          $errors[] = "Invalid frame style ID: $id.";
      }
      return $errors;
    }

    public function validateFrameShapeID(string|int $id): array {
      $errors = [];
      $result = Model::table('frameShapeOptions')->select('frameShapeOption_ID')->where('frameShapeOption_ID', $id)->get();
      if (empty($result)) {
          $errors[] = "Invalid frame shape ID: $id.";
      }
      return $errors;
    }

    public function validateFrameMaterialID(string|int $id): array {
      $errors = [];
      $result = Model::table('frameMaterialOptions')->select('frameMaterialOption_ID')->where('frameMaterialOption_ID', $id)->get();
      if (empty($result)) {
          $errors[] = "Invalid frame material ID: $id.";
      }
      return $errors;
    }

    public function validateFrameNosePadID(string|int $id): array {
      $errors = [];
      $result = Model::table('frameNosePadsOptions')->select('frameNosePadsOption_ID')->where('frameNosePadsOption_ID', $id)->get();
      if (empty($result)) {
          $errors[] = "Invalid frame nose pad ID: $id.";
      }
      return $errors;
    }

    public function validateColor(string $color = ''): array
    {
        $errors = [];
        if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
            $errors[] = 'Color must be a valid hex code.';
        }
        return $errors;
    }

    public function validateQuantity(int $quantity = 1): array
    {
        $errors = [];
        if ($quantity <= 0) {
            $errors[] = 'Quantity must be a positive integer.';
        }
        return $errors;
    }

    public function validateFrameWidth(int $frameWidth = 0): array
    {
        $errors = [];
        if ($frameWidth <= 0) {
            $errors[] = 'Frame width must be a positive integer.';
        }
        return $errors;
    }

    public function validateBridgeWidth(int $bridgeWidth = 0): array
    {
        $errors = [];
        if ($bridgeWidth <= 0) {
            $errors[] = 'Bridge width must be a positive integer.';
        }
        return $errors;
    }

    public function validateTempleLength(int $templeLength = 0): array
    {
        $errors = [];
        if ($templeLength <= 0) {
            $errors[] = 'Temple length must be a positive integer.';
        }
        return $errors;
    }

    public function validateFrameOptions(array $frameOptions = []) : array {
      $errors = [];
      if (count($frameOptions) == 0) {
          $errors[] = 'There must be at least one frame option.';
      }
      else {
          for ($i=0; $i < count($frameOptions); $i++) {
              $errors = array_merge(
                  $errors,
                  $this->validateColor($frameOptions[$i][":color_$i"]),
                  $this->validateQuantity($frameOptions[$i][":quantity_$i"]),
                  $this->validateFrameWidth($frameOptions[$i][":frameWidth_$i"]),
                  $this->validateBridgeWidth($frameOptions[$i][":bridgeWidth_$i"]),
                  $this->validateTempleLength($frameOptions[$i][":templeLength_$i"]),
              );
          }
      }
      return $errors;
    }

    public function validateFrameImages(array $images = []): array
    {
        $errors = [];
        if (count($images) == 0) {
          $errors[] = 'There must be at least four frame images.';
        }
        for ($i = 0; $i < count($images); $i++) {
          $errors = array_merge(
              $errors, 
              $this->validateFrameImage($images[$i])
          );
        }
        return $errors;
    }
}