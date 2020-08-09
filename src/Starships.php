<?php

  namespace Drupal\swapi;

  class Starships {
    private $queueStarships;

    public function getStarships() {
      $url = 'https://swapi.dev/api/starships/';

      $data = $this->getData($url);

      unset($data['count']);
      unset($data['next']);
      unset($data['previous']);

      $this->queueStarships = array_shift($data);

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
