<?php

/**
 * @file
 * Contains Drupal\configuration_form_example\Form\SettingsForm.
 */

namespace Drupal\configuration_form_example\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 *
 * @package Drupal\configuration_form_example\Form
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'configuration_form_example.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('configuration_form_example.settings');
    $form['bio'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Bio'),
      '#default_value' => $config->get('bio'),
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('configuration_form_example.settings')
      ->set('bio', $form_state->getValue('bio'))
      ->save();
  }

}
