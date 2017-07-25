<?php



namespace Drupal\book_module\Plugin\Block;
require 'vendor/autoload.php';

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

use AntoineAugusti\Books\Fetcher;
use GuzzleHttp\Client;

// use Drupal\custom_block\CustomGuzzleHttp;

/**
 * Provides a 'Custom Config' Block.
 *
 * @Block(
 *   id = "book_config_block",
 *   admin_label = @Translation("Book block"),
 *   category = @Translation("custom"),
 * )
 */

class ConfigBookBlock extends BlockBase  {

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['isbn'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('ISBN'),
      '#description' => $this->t('Enter ISBN of book.'),
      '#default_value' => isset($config['isbn']) ? $config['isbn'] : '',
    );

    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {

    $this->configuration['isbn']= $form_state->getValue('isbn');
    parent::blockSubmit($form, $form_state);
  }

  public function build() {
    $client = new Client(['base_uri' => 'https://www.googleapis.com/books/v1/']);
    $fetcher = new Fetcher($client);
    $book = $fetcher->forISBN($this->configuration['isbn']);
    // kint($book->authors[0]);
    // exit();
    $list[] = $this->t("Title of the book is : @title.",
                        array('@title' => $book->title)
                      );
    $list[] = $this->t("Subtitle of the book is : @subtitle.",
                        array('@subtitle' => $book->subtitle)
                      );
    $list[] = $this->t("Author of the book is : @author.",
                        array('@author' => $book->authors[0])
                      );
    $list[] = $this->t("Pages of the book is : @pages.",
                        array('@pages' => $book->pageCount)
                      );
    $list[] = $this->t("Publisher of the book is : @publisher.",
                        array('@publisher' => $book->publisher)
                      );
    $build = array(
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('Book Information'),
    );
    return $build;
    // kint($book->authors[1]);
    // exit();
  }
}
