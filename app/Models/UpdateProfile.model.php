<?php
namespace Models;

interface UpdateProfile {
  public function updateProfile(string $userID = '', array $requestData = [], array $fileData = []): array;
}