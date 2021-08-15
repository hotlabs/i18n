<?php

namespace I18n;

use Fuel\Core\Config;

class Uri extends \Fuel\Core\Uri
{
  public function __construct($uri = null)
  {
    parent::__construct($uri);
    $this->detect_language();
  }

  function detect_language()
  {
    Config::load('i18n', true);
    if (Config::get('i18n.active') && count($this->segments)) {
      $first = reset($this->segments);
      $locales = Config::get('i18n.locales', array());
      if (array_key_exists($first, $locales) && $first != Config::get('language')) {
        array_shift($this->segments);
        $this->uri = implode('/', $this->segments);
        Config::set('language', $first);
        Config::set('locale', $locales[$first]);
      }
    }
  }
}