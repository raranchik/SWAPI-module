<?php

  namespace Drupal\swapi;

  class Planets {
    private $queuePlanets;

    public function getPlanets() {
      $url = 'https://swapi.dev/api/planets/';

      $data = $this->getData($url);

      unset($data['count']);
      unset($data['next']);
      unset($data['previous']);

      $this->queuePlanets = array_shift($data);

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
