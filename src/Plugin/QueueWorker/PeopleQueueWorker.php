<?php

  namespace Drupal\swapi\Plugin\QueueWorker;

  use Drupal\Core\Queue\QueueWorkerBase;
  use Drupal\node\Entity\Node;
  use Drupal\ultimate_cron\Signal;
  use Drupal\ultimate_cron;
  use Drupal\ultimate_cron\Entity\CronJob;
  /**
   * Processes Node Tasks.
   *
   * @QueueWorker(
   *   id = "people_queue_worker",
   *   title = @Translation("People node"),
   *   cron = {"time" = 60}
   * )
   */

  class PeopleQueueWorker extends QueueWorkerBase {
    public function processItem($character) {
      // Создание ноды People
      $node = Node::create([
        'type' => 'people',
        'title' => $character['name'],
      ]);
      foreach ($character as $field => $fieldValue) {
        $node->set(('field_' . $field), $fieldValue);
      }

      // Получение id ноды Planets на которую ссылается нода People
      $idNodePlanet = $this->loadNidPlanets($character['homeworld']);

      // Если id существует, то в референс поле укажи на какую ноду Planets ссылаться
      // Иначе выполни cron job создания нод Planets
      // Загрузи id нужной ноды Planet и присвой его референс полю
      if (!is_null($idNodePlanet)) {
          $node->set('field_reference_planet', $idNodePlanet);
      } else {
        $this->loadCallbackPlanet();
        $idNodePlanet = $this->loadNidPlanets($character['homeworld']);
        $node->set('field_reference_planet', $idNodePlanet);
      }

      // Костыльный автокоплит
      $dataPlanet = $this->getDataPlanet($character['homeworld']);
      $node->set('field_test', $dataPlanet['name']);

      // Сохраненение ноды
      $this->saveNode($node);
    }

    // Проверка существования ноды Planets
    private function existsNodePlanet($field_url) {
      $storage_handler = \Drupal::entityTypeManager()->getStorage('node');
      $node = $storage_handler->loadByProperties([
        'type' => 'planets',
        'field_url' => $field_url,
        ]);

      return empty($node);
    }

    // Публикация ноды
    private function saveNode($node){
      $node->setPublished(true);
      $node->save();
    }

    // Выполнение cron job Planets
    private function loadCallbackPlanet() {
      /** @var \Drupal\ultimate_cron\Entity\CronJob $job */
      $job = CronJob::loadMultiple([
        'swapi_cron_planets_job',
        'ultimate_cron_queue_planets_queue_worker',
      ]);
      $job->get('swapi_cron_planets_job');
      $job->get('ultimate_cron_queue_planets_queue_worker');
    }

    // Получение нужного id ноды Planets
    private function loadNidPlanets($homeworld) {
     $nid = \Drupal::entityQuery('node')
       ->condition('type', 'planets')
       ->condition('status', 1)
       ->condition('field_url', $homeworld)
       ->execute();

     return $nid;
    }

    // Костыльный автомокоплит
    private function getDataPlanet($baseUrl) {
      $url = str_replace('http', 'https', $baseUrl);

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
