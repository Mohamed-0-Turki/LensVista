<?php

namespace Models;

class Location extends LocationValidation
{
  private string $streetName;
  private string $city;
  private string $nearestLandMark;
  private int|string $buildingName;

  public function __construct(string $streetName, string $city, string $nearestLandMark, int|string $buildingName)
  {
    $this->streetName = $streetName;
    $this->city = $city;
    $this->nearestLandMark = $nearestLandMark;
    $this->buildingName = $buildingName;
  }

    public function getStreetName(): string
    {
      return $this->streetName;
    }
  
    public function setStreetName(string $streetName): void
    {
      $this->streetName = $streetName;
    }

    public function getCity(): string
    {
      return $this->city;
    }
  
    public function setCity(string $city): void
    {
      $this->city = $city;
    }

    public function getNearestLandMark(): string
    {
      return $this->nearestLandMark;
    }
  
    public function setNearestLandMark(string $nearestLandMark): void
    {
      $this->nearestLandMark = $nearestLandMark;
    }

    public function getBuildingName(): int|string
    {
      return $this->buildingName;
    }
  
    public function setBuildingName(int|string $buildingName): void
    {
      $this->buildingName = $buildingName;
    }
}