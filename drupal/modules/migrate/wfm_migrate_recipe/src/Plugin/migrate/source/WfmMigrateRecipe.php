<?php

/**
 * @file
 * Contains \Drupal\wfm_migrate_recipe\Plugin\migrate\source\WfmMigrateRecipe.
 */

namespace Drupal\wfm_migrate_recipe\Plugin\migrate\source;

use Wfm\Api\SageClient\Recipe;
use Drupal\migrate\Plugin\migrate\source\SourcePluginBase;

// The config should be stored in settings.php, or outside of docroot
require('config.php');

/**
 * Source plugin for WFM Recipe content.
 *
 * @MigrateSource(
 *   id = "wfm_migrate_recipe"
 * )
 */
class WfmMigrateRecipe extends SourcePluginBase {

  protected function initializeIterator() {
    $apiRecipe = new Recipe(API_KEY, API_SECRET, API_URL);
    // using getAllRecipes is the easiest, but might need to use getAllRecipeIds
    // or possibly recipeIterator
    $rows = $apiRecipe->getAllRecipes();
    // $rows must be an array or Traversable which yields arrays. That's all!
    return new \ArrayIterator($rows);
  }

  // We need these functions because we are extending an abstract class
  public function getIds() {
    return array(
      'id' => array(
        // Should be 'string' if the IDs are strings
        'type' => 'integer',
      ),
    );
  }

  public function fields() {
    return array(
      'id' => t('ID'),
    );
  }

  public function __toString() {
    return (string) $this->query;
  }


}
