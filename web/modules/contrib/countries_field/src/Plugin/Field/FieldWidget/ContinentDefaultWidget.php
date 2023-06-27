<?php

namespace Drupal\countries_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'country_default' widget.
 *
 * @FieldWidget(
 *   id = "continent_default",
 *   label = @Translation("Continent select"),
 *   field_types = {
 *     "continent"
 *   }
 * )
 */
class ContinentDefaultWidget extends WidgetBase {

  /**
   * @inheritDoc
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $serviceContinents = \Drupal::service('countries_field.continents');
    $continents = $serviceContinents->getContinentsData();
    $element['value'] = $element + [
      '#type' => 'select',
      '#options' => $continents,
      '#empty_value' => '',
      '#default_value' => (isset($items[$delta]->value) && isset($continents[$items[$delta]->value])) ? $items[$delta]->value : NULL,
      '#description' => t('Select a Continent'),
      '#attributes' => [
        'data-id' => 'field-continent',
      ],
    ];
    return $element;
  }

}
