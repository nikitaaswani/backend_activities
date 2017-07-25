<?php

namespace Drupal\custom_block;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CustomGuzzleHttp {

  public function performRequest($siteUrl) {
    $client = new \GuzzleHttp\Client();
    try {
      $res = $client->get($siteUrl, ['http_errors' => false]);
      return $res->getBody()->getContents();
    } catch (RequestException $e) {
      return($this->t('Error'));
    }
  }

  public function generateUrl($cityname) {
    $config = \Drupal::config('my_module.settings.appid');
    $app_id=$config->get('appid');
    $url="http://api.openweathermap.org/data/2.5/weather?q=".$cityname."&appid=".$app_id;
    // return($url
    $result = $this->performRequest($url);
    $data = json_decode($result);
    return $data;
  }
}
