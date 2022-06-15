<?php
  namespace Drupal\exchange_rate\Plugin\Block;

  use Drupal\Core\Access\AccessResultAllowed;
  use Drupal\Core\Block\BlockBase;
  use Drupal\Core\Form\FormStateInterface;
  use Drupal\Core\Session\AccountInterface;

  /**
   * Provides a block with simple text.
   *
   * @Block (
   *   id = "simple_exchange_rate",
   *   admin_label = @Translation ("Exchange rate block")
   * )
   */
  class ExchangeRate extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
      return [
        '#type'   => 'markup',
        '#markup' => 'Exchange rate output' . '<br>' . 'Hello',

      ];
    }

    /**
     * {@inheritdoc}
     */
    protected function blockAccess(AccountInterface $account) {
      return AccessResultAllowed::allowedIfHasPermission($account, 'access content');
    }

    /**
     * {@inheritdoc }
     */
    public function blockForm($form, FormStateInterface $form_state) {
      $config = $this->getConfiguration();

      return $form;
    }
    public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['simple_block_settings'] = $form_state->getValue('simple_block_settings');
    }

  }
