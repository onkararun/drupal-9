<?php

namespace Drupal\countries_field\Plugin\Field\FieldWidget;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field\Entity\FieldConfig;

/**
 * Plugin implementation of the 'country_default' widget.
 *
 * @FieldWidget(
 *   id = "country_continent_widget",
 *   label = @Translation("Country & continent Select"),
 *   field_types = {
 *     "country"
 *   }
 * )
 */
class CountryContinentWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'continent' => FALSE,
    ] + parent::defaultSettings();
  }

  /**
   * @inheritDoc
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['continent'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Activate Continent'),
      '#default_value' => $this->getSetting('continent'),
    ];
    return $element;
  }

  /**
   * @inheritDoc
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $countries = $this->getCountries();
    $continents = $this->getContinents();
    // @todo Need cleaning code and make ajax working & and values saved.
    if ($this->getSetting('continent') == TRUE) {
      $form['#attached']['library'][] = 'countries_field/countries_field';
      $element['continent'] = [
        '#type' => 'select',
        '#options' => $continents,
        '#empty_value' => '',
        '#default_value' => (isset($items[$delta]->value) && isset($continents[$items[$delta]->value])) ? $items[$delta]->value : NULL,
        '#description' => t('Select a Continent'),
        '#validated' => TRUE,
        '#attributes' => [
          'data-id' => 'field-continent',
        ],
      ];
    }
    $element['country'] = [
      '#type' => 'select',
      '#options' => $countries,
      '#empty_value' => '',
      '#default_value' => (isset($items[$delta]->value) && isset($countries[$items[$delta]->value])) ? $items[$delta]->value : NULL,
      '#description' => t('Select a country'),
      '#validated' => TRUE,
      '#attributes' => [
        'data-id' => 'field-country',
      ],
    ];
    return $element;
  }

  /**
   * Retrieve continents.
   */
  private function getContinents() {
    $serviceContinents = \Drupal::service('countries_field.continents');
    return $serviceContinents->getContinentsData();
  }

  /**
   * Get countries.
   */
  private function getCountries($continentCode = 'all') {
    $continentCode = ($continentCode == '') ? 'all' : $continentCode;
    $serviceCountries = \Drupal::service('countries_field.countries');
    return $serviceCountries->getCountriesData($continentCode);
  }

  /**
   * Get Continent field name.
   */
  private function getFieldName(EntityInterface $entity) {
    $properties = $entity->getTypedData()
      ->getDataDefinition()
      ->getPropertyDefinitions();
    foreach ($properties as $property) {
      if ($property instanceof FieldConfig) {
        if ($property->getType() === 'continent') {
          return $property->getName();
        }
      }
    }
    return NULL;
  }

}
