<?php

namespace Drupal\countries_field;

/**
 * Class Continents.
 *
 * @package Drupal\countries_field
 */
class Continents {

  /**
   * Database.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Countries constructor.
   */
  public function __construct() {
    $this->database = \Drupal::database();
  }

  /**
   * Return Continents.
   */
  public function populate() {
    return [
      (object) ['code' => 'af', 'name' => 'Africa'],
      (object) ['code' => 'as', 'name' => 'Asia'],
      (object) ['code' => 'eu', 'name' => 'Europe'],
      (object) ['code' => 'na', 'name' => 'North America'],
      (object) ['code' => 'sa', 'name' => 'South America'],
      (object) ['code' => 'oc', 'name' => 'Oceania'],
      (object) ['code' => 'an', 'name' => 'Antarctica'],
    ];
  }

  /**
   * Get countries Data.
   *
   * @return array
   *   Return continents options.
   */
  public function getContinentsData() {
    $continents = $this->getContinents();
    $data = [];
    foreach ($continents as $continent) {
      $data[$continent->code] = t($continent->name);
    }
    return $data;
  }

  /**
   * Retrieve all continents.
   *
   * @return mixed
   *   Return object.
   */
  public function getContinents() {
    $query = $this->database->select('continents', 'c');
    $query->fields('c', ['code', 'name']);
    return $query->execute()->fetchAll();
  }

  /**
   * Insert continents in Database.
   */
  public function insertContinents() {
    // Add all continents.
    foreach ($this->populate() as $continent) {
      $this->insertContinent($continent);
    }
  }

  /**
   * Insert continent in Database.
   */
  public function insertContinent($continent) {
    try {
      // Prepare continent insert query.
      $query = $this->database->insert('continents')
        ->fields(['code', 'name'])
        ->values([
          'code' => $continent->code,
          'name' => $continent->name,
        ]);
      // Execute continent insert query.
      $query->execute();
    }
    catch (\Exception $e) {
      // Catch any errors, just to prevent anything from ever
      // being reported to screen.
      \Drupal::messenger()
        ->addError("Unable to complete this step : " . $e->getMessage());
      return;
    }
  }

  /**
   * Return Database schema.
   */
  public function getDBStructure() {
    return [
      'description' => 'Continents',
      'fields' => [
        'code' => [
          'description' => 'Code',
          'type' => 'varchar',
          'length' => 255,
          'not null' => TRUE,
          'default' => '',
        ],
        'name' => [
          'description' => 'Region name',
          'type' => 'varchar',
          'length' => 255,
          'not null' => TRUE,
          'default' => '',
        ],
      ],
      'primary key' => ['code'],
    ];
  }

}
