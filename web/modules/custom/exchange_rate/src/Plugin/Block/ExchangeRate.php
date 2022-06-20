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
    function afilt($value){
      if ($value == "UAH" or $value== "PLN"){
        return 1;
      }
    }
    public function build() {
      $client = new Client();
      try {
        $response = $client->get('https://api.fastforex.io/fetch-all?api_key=62a9217c31-5f4583eee5-rdiozz');
        $result   = json_decode($response->getBody(), TRUE);
      }
      catch (RequestException $e) {
        return '';
      }
      $valueout = '';
//      foreach($result ["results"] as $key => $value)
//      {
//        $valueout .= $key . ' - ' . round($value,2) . '<br>';
//      }
      foreach (['UAH', 'EUR', 'GBP', 'CHF', 'PLD'] as $key => $value)
      {

          $result["results"][$value]. "<br>";
      }
      return [
        '#type'   => 'markup',
        '#markup' => $valueout
      ];
    }

    public function getCacheMaxAge() {
      return 0;
    }

  }
