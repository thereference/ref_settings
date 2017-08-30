<?php
/**
 * Created by PhpStorm.
 * User: s.deboeck
 * Date: 28/08/2017
 * Time: 10:02
 */

namespace Drupal\ref_settings\ParamConverter;

use Drupal\Core\ParamConverter\ParamConverterInterface;
use Drupal\ref_settings\Entity\Settings;
use Symfony\Component\Routing\Route;

class SettingsConverter implements ParamConverterInterface {
  /**
   * {@inheritdoc}
   */
  public function convert($value, $definition, $name, array $defaults) {
    return Settings::loadByName($value);
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route) {
    return (!empty($definition['type']) && $definition['type'] == 'settings');
  }
}