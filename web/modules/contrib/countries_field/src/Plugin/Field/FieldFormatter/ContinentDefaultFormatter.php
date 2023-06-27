<?php

namespace Drupal\countries_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'country' formatter.
 *
 * @FieldFormatter(
 *   id = "continent_default",
 *   module = "continent",
 *   label = @Translation("Continent"),
 *   field_types = {
 *     "continent"
 *   }
 * )
 */
class ContinentDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $serviceCountries = \Drupal::service('countries_field.continents');
    $countries = $serviceCountries->getContinentsData();
    foreach ($items as $delta => $item) {
      if (isset($countries[$item->value])) {
        $elements[$delta] = ['#markup' => $countries[$item->value]];
      }
    }
    return $elements;
  }

}
