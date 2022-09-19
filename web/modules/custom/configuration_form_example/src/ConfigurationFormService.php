<?php

/**
 * @file
 * Contains Drupal\configuration_form_example\ConfigurationFormService.
 */

namespace Drupal\configuration_form_example;

class ConfigurationFormService {
  
  protected $configuration_value;
  
  public function __construct() {
    $this->configuration_value = \Drupal::config('configuration_form_example.settings');
  }
  
  public function getValue() {
    return $this->configuration_value;
  }
  
}