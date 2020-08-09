<?php

  namespace Drupal\swapi;

  class Vehicles {
    private $queueVehicles;

    public function getVehicles() {
      $url = 'https://swapi.dev/api/vehicles/';

      $data = $this->getData($url);

      unset($data['count']);
      unset($data['next']);
      unset($data['previous']);

      $this->queueVehicles = array_shift($data);

      return $this->queueVehicles;
    }


    // Устанавливаем соединение с swapi.dev и получаем данные Vehicles
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
