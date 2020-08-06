<?php

  namespace Drupal\swapi;

  class People {
    private $queuePeople;

    public function getPeople() {
      $url = 'https://swapi.dev/api/people/';

      $data = $this->getData($url);

      unset($data['count']);
      unset($data['next']);
      unset($data['previous']);

      $this->queuePeople = array_shift($data);

      return $this->queuePeople;
    }

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
