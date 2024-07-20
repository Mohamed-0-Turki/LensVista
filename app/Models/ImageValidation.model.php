private Location $location;

public function getLocation(): Location
{
    return $this->location;
}

public function setLocation(Location $location = null): void
{
    $this->location = $location;
}