<?php
// Извлечение данных со swapi.dev

namespace Drupal\swapi;

class DataRetrieval {
  private $People;
  private $Starships;
  private $Species;
  private $Planets;
  private $Vehicles;
  private $Films;

  public function getPeople(){
    $url = 'https://swapi.dev/api/people/';

    $data = $this->getData($url);

    unset($data['count']);
    unset($data['next']);
    unset($data['previous']);

    $this->People = array_shift($data);

    return $this->People;
  }

  public function getStarships(){
    $url = 'https://swapi.dev/api/starships/';

    $data = $this->getData($url);

    unset($data['count']);
    unset($data['next']);
    unset($data['previous']);

    $this->Starships = array_shift($data);

    return $this->Starships;
  }

  public function getSpecies(){
    $url = 'https://swapi.dev/api/species/';

    $data = $this->getData($url);

    unset($data['count']);
    unset($data['next']);
    unset($data['previous']);

    $this->Species = array_shift($data);

    return $this->Species;
  }

  public function getPlanets(){
    $url = 'https://swapi.dev/api/planets/';

    $data = $this->getData($url);

    unset($data['count']);
    unset($data['next']);
    unset($data['previous']);

    $this->Planets = array_shift($data);

    return $this->Planets;
  }

  public function getVehicles(){
    $url = 'https://swapi.dev/api/vehicles/';

    $data = $this->getData($url);

    unset($data['count']);
    unset($data['next']);
    unset($data['previous']);

    $this->Vehicles = array_shift($data);

    return $this->Vehicles;
  }

  public function getFilms(){
    $url = 'https://swapi.dev/api/films/';

    $data = $this->getData($url);

    unset($data['count']);
    unset($data['next']);
    unset($data['previous']);

    $this->Films = array_shift($data);

    return $this->Films;
  }

  private function getData($url) {

    $ch = curl_init();

    $optionsCURL = array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
    );

    curl_setopt_array($ch, $optionsCURL);

    $dataJSON = curl_exec($ch);
    $dataDECODE = json_decode($dataJSON, true);

    curl_close($ch);

    return $dataDECODE;
  }
}
