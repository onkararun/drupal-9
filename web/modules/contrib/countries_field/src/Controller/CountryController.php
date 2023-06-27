<?php

namespace Drupal\countries_field\Controller;

use Zend\Diactoros\Response\JsonResponse;

/**
 * Class CountryController.
 *
 * @package Drupal\countries_field\Controller
 */
class CountryController {

  /**
   * Retrieve countries by continent.
   */
  public function getCountriesByContinent() {
    $request = \Drupal::request()->request;
    $data = [];
    if ($request->has('continent_code')) {
      $code = $request->get('continent_code');
      $serviceCountries = \Drupal::service('countries_field.countries');
      if (!empty($code) && is_string($code) && strlen($code) == 2) {
        $data = $serviceCountries->getCountriesDataByContinent($code);
      }
      if (empty($code) || $code == 'all') {
        $data = $serviceCountries->getCountriesDataByContinent();
      }
    }
    return new JsonResponse($data);
  }

}
