<?php
/**
 * @file
 * Contains \Drupal\advertiser\Entity\Advertiser.
 */

namespace Drupal\advertiser\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the Advertiser entity.
 *
 * @ingroup advertiser
 *
 * @ContentEntityType(
 *   id = "advertiser",
 *   label = @Translation("Advertiser"),
 *   base_table = "advertiser",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "advertiser_name",
 *     "uuid" = "uuid",
 *   },
 * )
 */
class Advertiser extends ContentEntityBase implements ContentEntityInterface {

  /**
   * {@inheritdoc}
   */
  public function getWebsite() {
    return $this->get('advertiser_website')->get(0)->get('value')->getValue();
  }

  /**
   * {@inheritdoc}
   */
  public function setWebsite($advertiser_website) {
    $this->get('advertiser_website')->value = $advertiser_website;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getImage() {
    return $this->get('advertiser_image')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setImage($advertiser_image) {
    $this->get('advertiser_image')->value = $advertiser_image;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getEmail() {
    return $this->get('mail')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setEmail($mail) {
    $this->get('mail')->value = $mail;
    return $this;
  }

  /**
   * Determines the schema for the base_table property defined above.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
        ->setLabel(t('ID'))
        ->setDescription(t('The ID of the Advertiser entity.'))
        ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Contact entity.'))
      ->setReadOnly(TRUE);

    // Name field for the advertiser.
    $fields['advertiser_name'] = BaseFieldDefinition::create('string')
        ->setLabel(t("The advertiser's name"))
        ->setDescription(t('The name of the advertiser.'))
        ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
          'text_processing' => 0,
        ));

    // Website field for the advertiser.
    $fields['advertiser_website'] = BaseFieldDefinition::create('string')
        ->setLabel(t("The advertiser's website"))
        ->setDescription(t('The website address of the advertiser.'))
        ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
          'text_processing' => 0,
        ));

    // Logo image field for the advertiser.
    $fields['advertiser_image'] = BaseFieldDefinition::create('uri')
      ->setLabel(t('Image'))
      ->setDescription(t('An image representing the feed.'));

    // Email field for the advertiser.
    $fields['mail'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email'))
      ->setDescription(t('The email of this user.'))
      ->setDefaultValue('')
      ->addConstraint('UserMailUnique')
      ->addConstraint('UserMailRequired')
      ->addConstraint('ProtectedUserField');

    return $fields;
  }

}
