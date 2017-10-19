<?php

namespace Drupal\draco_cache_demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\user\UserStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block for an example.
 *
 * @Block (
 *   id = "draco_cache_demo_block",
 *   admin_label = @Translation("Cache demo block")
 * )
 */
class CacheDemoBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * User storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $userStorage;

  /**
   * Renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * CacheDemoBlock constructor.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   Current user.
   * @param \Drupal\user\UserStorageInterface $user_storage
   *   User storage.
   * @param \Drupal\Core\Render\Renderer $renderer
   *   Renderer.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxyInterface $current_user, UserStorageInterface $user_storage, Renderer $renderer) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
    $this->userStorage = $user_storage;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('entity_type.manager')->getStorage('user'),
      $container->get('renderer')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $output = $this->t('<em>Kramer</em>: I never heard of this %name. And frankly it sounds made up', ['%name' => $this->currentUser->getDisplayName()]);

    /** @var \Drupal\user\Entity\User $account */
    $account = $this->userStorage->load($this->currentUser->id());
    $build = [
      '#markup' => $output,
      '#cache' => [
        'context' => ['user'],
      ],
    ];
    $this->renderer->addCacheableDependency($build, $account);
    return $build;
  }

}
