<?php

  namespace Drupal\swapi\Plugin\QueueWorker;

  use Drupal\Core\Queue\QueueWorkerBase;
  use Drupal\node\Entity\Node;

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
      $node = Node::create([
        'type' => 'people',
        'title' => $character['name'],
      ]);

      foreach ($character as $field => $fieldValue) {
        $node->set(('field_' . $field), $fieldValue);
      }

/*      $nid = $this->loadNidPlanets($character['homeworld']);

      $node->set('field_test', $nid);*/
/*      $node->field_reference[] = [
        'target_id' => $nid,
      ];*/

      $dataPlanet = $this->getDataPlanet($character['homeworld']);

      $node->set('field_test', $dataPlanet['name']);
/*      $node->field_reference[] = [
        'target_id' => $dataPlanet['name'],
      ];*/

      $this->saveNode($node);
    }

    private function saveNode($node){
      $node->setPublished(true);
      $node->save();
    }

    private function loadNidPlanets($homeworld) {
      $storage_handler = \Drupal::entityTypeManager()->getStorage('node');
      $nodes = $storage_handler->loadByProperties(['type' => 'planets']);

/*      $nids = \Drupal::entityQuery('node')->condition('type', 'planets')->execute();
      $nodes = Node::loadMultiple($nids);*/

      foreach ($nodes as $node) {
        $urlPlanet = $node->get('field_url');

        if ($homeworld == $urlPlanet) {
          return $node->id();
        }
      }
    }

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
