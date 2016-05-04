<?php

/**
 * @file
 * Contains \Drupal\wfm_migrate_product_ss\Plugin\migrate\source\ProductStoreSpecificSNode.
 */

namespace Drupal\wfm_migrate_product_ss\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
//use DateTime;

/**
 * Source plugin for Product Store-Specific content.
 *
 * @MigrateSource(
 *   id = "product_ss_node"
 * )
 */
class ProductStoreSpecificNode extends SqlBase {

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
    $query = $this->select('storeinfo', 's')
      ->fields('s', [
        'identifier',
        'tlc',
        'currency',
        'retailuom',
        'price',
        'pricemultiple',
        'saleprice',
        'salepricemultiple',
        'salestart',
        'saleend',
        'available',
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
      'tlc' => $this->t('Three Letter Code'),
      'currency' => $this->t('Currency'),
      'retailuom' => $this->t('Retail Unit of Measure'),
      'price' => $this->t('Price'),
      'pricemultiple' => $this->t('Price Multiple'),
      'salestart' => $this->t('Sale Start Date'),
      'saleend' => $this->t('Sale End Date'),
      'available' => $this->t('Available'),
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
        'alias' => 's',
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
    $start = $row->getSourceProperty('salestart');
    if (!is_null($start)) {
      drupal_set_message('start:' . $start) ;
      $timestamp = strtotime($start);
      $start = date("Y-m-d\TH:i:s", $timestamp);
//    $timestamp = new DateTime($row->modified_at2);
//    $start = $timestamp->format('Y-m-d H:i:s');
      drupal_set_message('reformatted start: ' . $start);
      $row->setSourceProperty('salestart',$start);
    }

    $end = $row->getSourceProperty('saleend');
    if (!is_null($end)) {
      drupal_set_message('end:' . $end);
      $timestamp = strtotime($start);
      $end = date("Y-m-d\TH:i:s", $timestamp);
      drupal_set_message('reformatted end: ' . $end);
      $row->setSourceProperty('saleend',$end);
    }

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
