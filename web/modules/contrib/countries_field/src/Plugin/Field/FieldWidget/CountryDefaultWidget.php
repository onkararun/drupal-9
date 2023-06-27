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
 *   id = "country_default",
 *   label = @Translation("Country select"),
 *   field_types = {
 *     "country"
 *   }
 * )
 */
class CountryDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta,
    array $element,
    array &$form,
    FormStateInterface $form_state) {
    $countries = $this->getCountries();
    $element['value'] = $element + [
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
   * Get countries.
   */
  private function getCountries() {
    $attributes = \Drupal::request()->attributes;
    $entity = NULL;
    $field = NULL;
    $continentCode = 'all';
    if ($attributes->has('_entity_form')) {
      $entityType = $attributes->get('_entity_form');
      switch ($entityType) {
        case 'node.edit':
          $entity = $attributes->get('node');
      }
      if ($entity instanceof EntityInterface) {
        $field = $this->getFieldName($entity);
        if (!empty($field)) {
          $continentCode = $entity->get($field)->value;
          $continentCode = ($continentCode == '') ? 'all' : $continentCode;
        }
      }
    }
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
