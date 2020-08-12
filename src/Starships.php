<?php

  namespace Drupal\swapi;

  class Starships {
    private $queueStarships;

    public function getStarships() {
      $data = [];
      $baseUrl = 'https://swapi.dev/api/starships/';

      $examlpeRequest = $this->getData($baseUrl);
      $countStarships = $examlpeRequest['count'];

      for ($i = 1; $i <= $countStarships; $i++) {
        $data[] = $this->getData($baseUrl . $i . '/');
      }

      $this->queueStarships = $data;

      return $this->queueStarships;
    }


    // Устанавливаем соединение с swapi.dev и получаем данные Starships
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
