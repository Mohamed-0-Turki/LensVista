<?php
namespace Models;


interface FetchProfile {
  public function fetchProfile(string $userID = ''): array;
}