<?php

namespace Drupal\draco_cache_demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block for an example.
 *
 * @Block (
 *   id = "draco_cache_demo_block",
 *   admin_label = @Translation("Cache demo block")
 * )
 */
class CacheDemoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('Here is some block output for you!'),
    ];
  }

}
