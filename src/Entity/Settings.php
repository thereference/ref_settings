<?php

namespace Drupal\ref_settings\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ref_settings\SettingsInterface;

/**
 * Defines the settings entity.
 *
 * @ContentEntityType(
 *   id = "settings",
 *   label = @Translation("Settings"),
 *   base_table = "settings",
 *   data_table = "settings_field_data",
 *   entity_keys = {
 *     "id" = "id",
 *     "langcode" = "langcode",
 *     "bundle" = "type",
 *     "uuid" = "uuid",
 *     "name" = "name",
 *   },
 *   handlers = {
 *     "form" = {
 *       "default" = "Drupal\ref_settings\Form\SettingsForm",
 *       "edit" = "Drupal\ref_settings\Form\SettingsForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *     "storage_schema" = "Drupal\ref_settings\SettingsStorageSchema",
 *     "access" = "Drupal\ref_settings\SettingsAccessControlHandler",
 *     "translation" = "Drupal\content_translation\ContentTranslationHandler"
 *   },
 *   links = {
 *     "edit-form" = "/admin/structure/settings_type/settings/{settings}/edit",
 *     "collection" = "/admin/structure/settings_type/settings",
 *     "canonical" = "/admin/structure/settings_type/settings/{settings}",
 *   },
 *   permission_granularity = "bundle",
 *   bundle_entity_type = "settings_type",
 *   fieldable = TRUE,
 *   translatable = TRUE,
 *   field_ui_base_route = "entity.settings_type.edit_form",
 * )
 */
class Settings extends ContentEntityBase implements SettingsInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    $settingsType = SettingsType::load($this->getName());
    return $settingsType->label();
  }

  /**
   * Gets the settings name.
   *
   * @return string
   *   Name of the setting.
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * Sets the settings name.
   *
   * @param string $name
   *   The settings name.
   *
   * @return \Drupal\ref_settings\Entity\Settings
   *   The called settings entity.
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * Load the settings entity by name.
   *
   * @param string $name
   *   The settings name.
   *
   * @return \Drupal\ref_settings\Entity\Settings
   *   The called settings entity.
   */
  public static function loadByName($name) {
    $entityTypeManager = \Drupal::entityTypeManager();
    $settings = $entityTypeManager->getStorage('settings')->loadByProperties(['name' => $name, 'type' => $name]);
    return reset($settings);
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    if ($entity_type->hasKey('name')) {
        $fields[$entity_type->getKey('name')] = BaseFieldDefinition::create('string')
          ->setLabel(new TranslatableMarkup('Name'))
          ->setRequired(TRUE)
          ->setReadOnly(TRUE);
    }

    return $fields;
  }
}