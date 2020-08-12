<?php

  namespace Drupal\swapi;

  class Vehicles {
    private $queueVehicles;

    public function getVehicles() {
      $data = [];
      $baseUrl = 'https://swapi.dev/api/vehicles/';

      $examlpeRequest = $this->getData($baseUrl);
      $countVehicles = $examlpeRequest['count'];

      for ($i = 1; $i <= $countVehicles; $i++) {
        $data[] = $this->getData($baseUrl . $i . '/');
      }

      $this->queueVehicles = $data;

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
