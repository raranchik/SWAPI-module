<?php

  namespace Drupal\swapi;

  class Films {
    private $queueFilms;

    public function getFilms() {
      $url = 'https://swapi.dev/api/films/';

      $data = $this->getData($url);

      unset($data['count']);
      unset($data['next']);
      unset($data['previous']);

      $this->queueFilms = array_shift($data);

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
