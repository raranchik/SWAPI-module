<?php

  namespace Drupal\swapi;

  class Species {
    private $queueSpecies;

    public function getSpecies() {
      $data = [];
      $baseUrl = 'https://swapi.dev/api/species/';

      $examlpeRequest = $this->getData($baseUrl);
      $countSpecies = $examlpeRequest['count'];

      for ($i = 1; $i <= $countSpecies; $i++) {
        $data[] = $this->getData($baseUrl . $i . '/');
      }

      $this->queueSpecies = $data;

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
