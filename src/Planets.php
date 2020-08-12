<?php

  namespace Drupal\swapi;

  class Planets {
    private $queuePlanets;

    public function getPlanets() {
      $data = [];
      $baseUrl = 'https://swapi.dev/api/planets/';

      $examlpeRequest = $this->getData($baseUrl);
      $countPlanets = $examlpeRequest['count'];

      for ($i = 1; $i <= $countPlanets; $i++) {
        $data[] = $this->getData($baseUrl . $i . '/');
      }

      $this->queuePlanets = $data;

      return $this->queuePlanets;
    }


    // Устанавливаем соединение с swapi.dev и получаем данные Planets
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
