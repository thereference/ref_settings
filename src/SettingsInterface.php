<?php
/**
 * Created by PhpStorm.
 * User: s.deboeck
 * Date: 30/08/2017
 * Time: 17:29
 */

namespace Drupal\ref_settings;


use Drupal\Core\Entity\ContentEntityInterface;

interface SettingsInterface extends ContentEntityInterface {

  /**
   * Gets the name of the setting.
   *
   * @return string
   *   The name of the setting.
   */
  public function getName();

  /**
   * Sets the name of the setting.
   *
   * @param int $name
   *   The settings name.
   *
   * @return $this
   */
  public function setName($name);

  /**
   * Load the setting by name.
   *
   * @param int $name
   *   The settings name.
   *
   * @return $this
   */
  public static function loadByName($name);
}