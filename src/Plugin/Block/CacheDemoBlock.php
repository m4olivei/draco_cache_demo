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
    $output = $this->t('<em>Kramer</em>: You have any idea how much time I waste in this apartment?');
    $output .= '<br />';
    $output .= $this->t('<em>Jerry</em>: I could ballpark it. As of <strong>@date_time</strong> a tonne.', ['@date_time' => date('c')]);
    return [
      '#markup' => $output,
      '#cache' => [
        // We're not dependent on the current time, we don't need to be precise
        // (ie. max-age = 0 => uncacheable), we can accept some staleness in
        // Jerry's estimate.
        'max-age' => 30,
      ],
    ];
  }

}
