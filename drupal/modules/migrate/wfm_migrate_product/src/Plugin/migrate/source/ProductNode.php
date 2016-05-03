<?php

/**
 * @file
 * Contains \Drupal\wfmproduct\Plugin\migrate\source\ProductNode.
 */

namespace Drupal\wfm_migrate_product\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for Product content.
 *
 * @MigrateSource(
 *   id = "product_node"
 * )
 */
class ProductNode extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    /**
     * An important point to note is that your query *must* return a single row
     * for each item to be imported. We simply query
     * the base node data here, and pull in the relationships in prepareRow()
     * below.
     */
    $query = $this->select('products', 'p')
      ->fields('p', [
        'identifier',
        'brand',
        'description',
        'subTeamNumber',
        'subTeam',
        'size',
        'uom'
      ])
      ->orderBy('identifier');
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'identifier' => $this->t('Product ID'),
      'brand' => $this->t('Product Brand'),
      'description' => $this->t('Description of the product'),
      'subTeamNumber' => $this->t('Subteam Number'),
      'subTeam' => $this->t('Subteam'),
      'size' => $this->t('Size'),
      'uom' => $this->t('Unit of Measure'),
      // Note that this field is not part of the query above - it is populated
      // by prepareRow() below. You should document all source properties that
      // are available for mapping after prepareRow() is called.
//      'terms' => $this->t('Applicable styles'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'identifier' => [
        'type' => 'string',
        'alias' => 'p',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    /**
     * Let's go get the subTeam taxonomy tid for each product
     */

    /**
     * As explained above, we need to pull the style relationships into our
     * source row here, as an array of 'style' values (the unique ID for
     * the beer_term migration).
     */
//    $terms = $this->select('migrate_example_beer_topic_node', 'bt')
//      ->fields('bt', ['style'])
//      ->condition('bid', $row->getSourceProperty('bid'))
//      ->execute()
//      ->fetchCol();
//    $row->setSourceProperty('terms', $terms);

    // As we did for favorite beers in the user migration, we need to explode
    // the multi-value country names.
//    if ($value = $row->getSourceProperty('countries')) {
//      $row->setSourceProperty('countries', explode('|', $value));
//    }
    return parent::prepareRow($row);
//  }
  }
}
