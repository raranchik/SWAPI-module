<?php

  namespace Drupal\swapi;

  class Films {
    private $queueFilms;

    public function getFilms() {
      $data = [];
      $baseUrl = 'https://swapi.dev/api/films/';

      $examlpeRequest = $this->getData($baseUrl);
      $countFilms = $examlpeRequest['count'];

      for ($i = 1; $i <= $countFilms; $i++) {
        $data[] = $this->getData($baseUrl . $i . '/');
      }

      $this->queueFilms = $data;

      return $this->queueFilms;
    }


    // Устанавливаем соединение с swapi.dev и получаем данные Films
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
