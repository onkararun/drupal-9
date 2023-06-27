<?php

namespace Drupal\countries_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

/**
 * Plugin implementation of the 'country' field type.
 *
 * @FieldType(
 *   id = "continent",
 *   label = @Translation("Continent"),
 *   description = @Translation("Stores the ISO-2 name of a continent."),
 *   category = @Translation("Continent Fields"),
 *   default_widget = "continent_default",
 *   default_formatter = "continent_default"
 * )
 */
class ContinentField extends FieldItemBase {

  const CONTINENT_ISO2_MAXLENGTH = 2;

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Continent'));
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'char',
          'length' => static::CONTINENT_ISO2_MAXLENGTH,
          'not null' => FALSE,
        ],
      ],
      'indexes' => [
        'value' => ['value'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraint_manager = \Drupal::typedDataManager()
      ->getValidationConstraintManager();
    $constraints = parent::getConstraints();
    $constraints[] = $constraint_manager->create('ComplexData', [
      'value' => [
        'Length' => [
          'max' => static::CONTINENT_ISO2_MAXLENGTH,
          'maxMessage' => t('%name: the country iso-2 code may not be longer than @max characters.', [
            '%name' => $this->getFieldDefinition()
              ->getLabel(),
            '@max' => static::CONTINENT_ISO2_MAXLENGTH,
          ]),
        ],
      ],
    ]);
    return $constraints;
  }

}
