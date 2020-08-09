<?php

  namespace Drupal\swapi;

  class Species {
    private $queueSpecies;

    public function getSpecies() {
      $url = 'https://swapi.dev/api/species/';

      $data = $this->getData($url);

      unset($data['count']);
      unset($data['next']);
      unset($data['previous']);

      $this->queueSpecies = array_shift($data);

      return $this->queueSpecies;
    }


    // Устанавливаем соединение с swapi.dev и получаем данные Species
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
