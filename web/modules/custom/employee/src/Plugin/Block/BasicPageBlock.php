<?php

namespace Drupal\employee\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'Custom Block for Employee Form' Block.
 *
 * @Block(
 *   id = "custom_block_employee_form",
 *   admin_label = @Translation("Custom Employee Form Block"),
 *   category = @Translation("Custom"),
 * )
 */
class BasicPageBlock extends BlockBase implements BlockPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $form = \Drupal::formBuilder()->getForm('Drupal\employee\Form\EmployeeForm');
        return $form;
    }
}