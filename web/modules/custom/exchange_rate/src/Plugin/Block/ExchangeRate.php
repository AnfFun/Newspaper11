<?php
  namespace Drupal\exchange_rate\Plugin\Block;

  use Drupal\Core\Access\AccessResultAllowed;
  use Drupal\Core\Block\BlockBase;
  use Drupal\Core\Form\FormStateInterface;
  use Drupal\Core\Session\AccountInterface;
  use GuzzleHttp\Client;
  use GuzzleHttp\Exception\RequestException;

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
      $client = new Client();
      try {
        $response = $client->get('https://api.fastforex.io/fetch-all?api_key=62a9217c31-5f4583eee5-rdiozz');
        $result   = json_decode($response->getBody(), TRUE);
      }
      catch (RequestException $e) {
        return '';
      }
      return [
        '#type'   => 'markup',
        '#markup' => $result["results"]["UAH"] . ' -UAH',

      ];
    }

    public function getCacheMaxAge() {
      return 0;
    }

  }
