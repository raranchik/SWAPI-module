<?php

  namespace Drupal\swapi\Plugin\QueueWorker;

  use Drupal\Core\Queue\QueueWorkerBase;
  use Drupal\node\Entity\Node;

  /**
   * Processes Node Tasks.
   *
   * @QueueWorker(
   *   id = "species_queue_worker",
   *   title = @Translation("Species node"),
   *   cron = {"time" = 60}
   * )
   */

  class SpeciesQueueWorker extends QueueWorkerBase {
    public function processItem($specie) {
      $node = Node::create([
        'type' => 'species',
        'title' => 'Specie',
      ]);

      foreach ($specie as $field => $fieldValue) {
        $node->set(('field_' . $field), $fieldValue);
      }

      $this->saveNode($node);
    }

    private function saveNode($node){
      $node->setPublished(true);
      $node->save();
    }
  }
