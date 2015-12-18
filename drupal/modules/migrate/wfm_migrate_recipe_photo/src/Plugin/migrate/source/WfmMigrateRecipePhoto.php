<?php

/**
 * @file
 * Contains \Drupal\wfm_migrate_recipe_photo\Plugin\migrate\source\WfmMigrateRecipePhoto.
 */

namespace Drupal\wfm_migrate_recipe_photo\Plugin\migrate\source;

use Drupal\migrate\Row;
use Wfm\Api\SageClient\Recipe;
use Drupal\migrate\Plugin\migrate\source\SourcePluginBase;

// The config should be stored in settings.php, or outside of docroot
require('config.php');

/**
 * Source plugin for WFM Recipe content.
 *
 * @MigrateSource(
 *   id = "wfm_migrate_recipe_photo"
 * )
 */
class WfmMigrateRecipePhoto extends SourcePluginBase {

  protected function initializeIterator() {
    $apiRecipe = new Recipe(API_KEY, API_SECRET, API_URL);
    // using getAllRecipes is the easiest, but might need to use getAllRecipeIds
    // or possibly recipeIterator
    $apiRecipe->setLimit(10);
    //$rows = $apiRecipe->getAllRecipes();
    $rows = $apiRecipe->getRecipesModifiedSince(strtotime('-1 month'));
    // $rows must be an array or Traversable which yields arrays. That's all!
    //$it = new \ArrayIterator($rows);
    // Return all the images for all the rows.
    $uri_array = array();
    foreach ($rows as $row) {
      $status = $row['status'];
      if ($status == "Published") {
          foreach ($row['photos'] as $photo) {
            $uri_array[] = array('uri' => $photo['url']);
            //$uri_array += array('uri' => $row['photos']['url']);

          }
      }
    }
    $uri_it = new \ArrayIterator($uri_array);
    return $uri_it;
  }



  // We need these functions because we are extending an abstract class
  public function getIds() {
    return array(
      'uri' => array(
        // Should be 'string' if the IDs are strings
        'type' => 'string',
      ),
    );
  }

  public function fields() {
    return array(
      'id' => t('ID number for each recipe'),
      '_id' => t('Mongo ID for each recipe'),
      'title' => t('Title of recipe'),
      'modified_at' => 'Datetime recipe was last modified',
      'modified_at2' => 'Datetime recipe was last modified',
      'description' => 'Description',
      'comment_count' => 'Number of comments',
      'number_of_ratings' => 'Number of ratings',
      'created_at' => 'Created',
      'rating' => 'Rating',
      'weighted_rating' => 'Weighted Rating',
      'prep_time' => 'Preparation time',
      'serves' => 'Serves',
      'ingredients' => 'Ingredients',
      'directions' => 'Directions',
      'photos' => 'Photographs',
      'special_diet' => 'Special Diet Flag',
      'type_dish' => 'Type of dish',
      'cuisine' => 'Cuisine',
      'occasion' => 'Occasion',
      'category' => 'Category',
      'categories' => 'Categories',
      'main_ingredient' => 'Main Ingredient in dish',
      //'cloudinary_images' => 'Cloudinary Images',
      'image_filename' => 'Image Filename',
      'field_hero_image' => 'Main image for the recipe',
      'image_alt_text' => 'Image title text',
      'image_title_text' => 'Image title text',
      'basic_nutrition' => t('Nutritional Info'),
    );
  }

  public function __toString() {
    return (string) $this->query;
  }

  public function prepareRow(Row $row) {
    // do my row mods here..

    // Bail if this is a non-published recipe
    //$status = $row->getSourceProperty("status");
    //if ($status != 'Published') {
    //  return FALSE;
    //}

    //$title = $row->getSourceProperty("title");
    //$photos = $row->getSourceProperty("photos");
    //$photos = $this->preparePhotos($title, $photos);
    //$row->setSourceProperty("uri", $photos);
    // set created to now..

    return parent::prepareRow($row);
  }


  public function preparePhotos($title, $photos) {
    $return = array();
    foreach ($photos as $photo) {
      $url = $photo['url'];
      $return[] = $url;
      $str = sprintf("photo:%s \n", $url);
      drush_print_r($str);
    }
    return $return;
  }


}
