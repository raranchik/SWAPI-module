<?php

  namespace Drupal\swapi;

  class People {
    private $queuePeople;

    public function getPeople() {
      $data = [];
      $baseUrl = 'https://swapi.dev/api/people/';

      $examlpeRequest = $this->getData($baseUrl);
      $countPeople = $examlpeRequest['count'];

      for ($i = 1; $i <= $countPeople; $i++) {
        $data[] = $this->getData($baseUrl . $i . '/');
      }

      $this->queuePeople = $data;

      return $this->queuePeople;
    }


    // Устанавливаем соединение с swapi.dev и получаем данные People
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
