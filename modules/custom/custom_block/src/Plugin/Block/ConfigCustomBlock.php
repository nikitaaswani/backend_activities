<?php

namespace Drupal\custom_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
// use Drupal\custom_block\CustomGuzzleHttp;

/**
 * Provides a 'Custom Config' Block.
 *
 * @Block(
 *   id = "weather_config_block",
 *   admin_label = @Translation("Weather block"),
 *   category = @Translation("custom"),
 * )
 */

class ConfigCustomBlock extends BlockBase  {

  // public function __construct(CustomGuzzleHttp $service) {
  //   $this->service = $service;
  // }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['city_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('City Name'),
      '#description' => $this->t('Name of city for which you want ot know the weather.'),
      '#default_value' => isset($config['city_name']) ? $config['city_name'] : '',
    );

    return $form;
  }

    public function blockSubmit($form, FormStateInterface $form_state) {

      $this->configuration['city_name']= $form_state->getValue('city_name');
      parent::blockSubmit($form, $form_state);
  }

  public function build() {
    $config = $this->getConfiguration();
    $content=\Drupal::service('custom_block.weather_api')->generateUrl($config['city_name']);
      // $date->main->temp_min
    $list['min_temp']['label'] = $this->t("Minimum temperature is: ");

    $list['min_temp']['content'] = $content->main->temp_min;
    $list['max_temp']['label'] = $this->t("Maximum temperature is: ");
    $list['max_temp']['content'] = $content->main->temp_max;
    $list['humidity']['label'] = $this->t("Humidity : ");
    $list['humidity']['content'] = $content->main->humidity;
    $list['pressure']['label'] = $this->t("Pressure : ");
    $list['pressure']['content'] = $content->main->pressure;
    $list['speed']['label'] = $this->t("Speed of wind :");
    $list['speed']['content'] = $content->wind->speed;
    $build['page_example_arguments'] = array(
      // The theme function to apply to the #items.
      '#theme' => 'weather_info',
      '#items' => $list,
      '#title' => $this->t('Weather information'),
      '#attached' => array(
        'library' => array(
          'custom_block/block-display',
        ),
      ),
    );
    return $build;
  }
}
