<?php
// Пространство имён формы
namespace Drupal\swapi\Form;

// Наследуем от FormBase
use Drupal\Core\Form\FormBase;
// FormStateInterface обрабатывает данные
use Drupal\Core\Form\FormStateInterface;

// Форма
class SwapiSearch extends FormBase {
  // Возвращает название формы
  public function getFormId(){
    return 'swapi_search';
  }
  // Объявление формы поиска
  public function buildForm (array $form, FormStateInterface $form_state) {
    // Поле для ввода адреса
    $form['search_url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Input url'),
      '#default_value' => 'https://swapi.dev/api/',
      '#description' => 'https://swapi.dev/api/people or add /1',
    );

    // Обёртка
    $form['actions']['#type'] = 'actions';
    // Кнопка сабмита
    $form['actions']['search_submit'] = array(
      '#type' => 'submit',
      '#value' => 'search',
      '#button_type' => 'primary',
    );

    $form['settings']['active'] = array(
      '#type' => 'radios',
      '#title' => $this
        ->t('Select what to show'),
      //'#default_value' => 0,
      '#options' => array(
        0 => $this
          ->t('People'),
        1 => $this
          ->t('Films'),
        2 => $this
          ->t('Starships'),
        3 => $this
          ->t('Vehicles'),
        4 => $this
          ->t('Planets'),
        5 => $this
          ->t('Species'),
      ),
    );

    $form['needs_accommodation'] = array(
      '#type' => 'checkbox',
      '#title' => $this
        ->t('Need Special Accommodations?'),
    );
    $form['accommodation'] = array(
      '#type' => 'container',
      '#attributes' => array(
        'class' => 'accommodation',
      ),
      '#states' => array(
        'invisible' => array(
          'input[name="needs_accommodation"]' => array(
            'checked' => FALSE,
          ),
        ),
      ),
    );
    $form['accommodation']['diet'] = array(
      '#type' => 'textfield',
      '#title' => $this
        ->t('Dietary Restrictions'),
    );

    return $form;
  }

  // Валидация формы
  public function validateForm (array &$form, FormStateInterface $form_state) {
    // Проверка на пустую строку
    if (strlen($form_state->getValue('search_url')) == 0) {
      $form_state->setErrorByName('search_url', $this->t('Incorrect url'));
    }
  }

  // Что происходит при сабмите
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::service('swapi.data_retrieval')->getData();
  }
}
