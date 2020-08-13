<?php

  namespace Drupal\swapi\Form;

  use Drupal\Core\Form\FormBase;
  use Drupal\Core\Form\FormStateInterface;
  use Drupal\node\Entity\Node;

  class PeopleForm extends FormBase {

    public function getFormId() {
      return 'people_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
      $form['People_form'] = array(
        '#type' => 'table',
        '#caption' => $this->t('People form'),
        '#header' => array(
          $this->t('Name'),
          $this->t('Birth year'),
          $this->t('Eye color'),
          $this->t('Gender'),
          $this->t('Hair color'),
          $this->t('Height'),
          $this->t('Mass'),
          $this->t('Skin color'),
          $this->t('Homeworld'),
          $this->t('Films'),
          $this->t('Species'),
          $this->t('Starships'),
          $this->t('Vehicles'),
          $this->t('Height'),
          $this->t('Url'),
          $this->t('Created'),
          $this->t('Edited'),
        ),
      );

      $node_storage = \Drupal::entityTypeManager()->getStorage('node');
      $nodes = $node_storage->loadByProperties(['type' => 'people']);

      $countNodePeople = \Drupal::entityQuery('node')
        ->condition('type', 'people')->count();

      $form['People_form'][1]['Name'] = $countNodePeople;

      return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
    }
  }
