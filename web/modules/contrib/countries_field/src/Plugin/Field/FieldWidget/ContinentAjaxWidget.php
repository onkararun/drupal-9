<?php

namespace Drupal\countries_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'country_default' widget.
 *
 * @FieldWidget(
 *   id = "continent_ajax",
 *   label = @Translation("Continent Ajax"),
 *   field_types = {
 *     "continent"
 *   }
 * )
 */
class ContinentAjaxWidget extends WidgetBase {

  /**
   * @inheritDoc
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $serviceContinents = \Drupal::service('countries_field.continents');
    $continent = $serviceContinents->getContinentsData();
    $form['#attached']['library'][] = 'countries_field/countries_field';
    $element['value'] = $element + [
      '#type' => 'select',
      '#options' => $continent,
      '#empty_value' => '',
      '#default_value' => (isset($items[$delta]->value) && isset($continent[$items[$delta]->value])) ? $items[$delta]->value : NULL,
      '#description' => t('Select a Continent'),
      '#attributes' => [
        'data-id' => 'field-continent',
      ],
    ];
    return $element;
  }

}
