<?php

/**
 * @file
 * Contains \Drupal\configuration_form_example\Controller\ConfigurationController.
 */

namespace Drupal\configuration_form_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ConfigurationController.
 */
class ConfigurationController extends ControllerBase {
  
  protected $configurationService;
  
  /**
   * Class constructor.
   */
  public function __construct($configurationService) {
    $this->configurationService = $configurationService;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('configuration_form_example.configuration_service')
    );
  }
  
  /**
   * Generates an example page.
   */
  public function configurationFormValue() {
    return array(
      '#markup' => t('Hello @value', array('@value' => $this->configurationService->getValue()->get('bio'))),
    );
  }
}