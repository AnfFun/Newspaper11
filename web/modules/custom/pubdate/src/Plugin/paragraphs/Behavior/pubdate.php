<?php

  namespace Drupal\pubdate\Plugin\paragraphs\Behavior;

  use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
  use Drupal\Core\Form\FormStateInterface;
  use Drupal\paragraphs\Annotation\ParagraphsBehavior;
  use Drupal\paragraphs\Entity\Paragraph;
  use Drupal\paragraphs\Entity\ParagraphsType;
  use Drupal\paragraphs\ParagraphInterface;
  use Drupal\paragraphs\ParagraphsBehaviorBase;

  /**
   * @ParagraphsBehavior(
   *   id = "pubdate_image_and_text",
   *   label = @Translation("Paragraph Image and Text settings"),
   *   description = @Translation("Allows to select image size and position."),
   *   weight = 0,
   * )
   */
  class pubdate extends ParagraphsBehaviorBase {

    /**
     * {@inheritdoc}
     */
    public static function isApplicable(ParagraphsType $paragraphs_type) {
      if ($paragraphs_type->id() == 'image_and_text') {
        return TRUE;
      }
      return FALSE;
    }

    /**
     * {@inheritdoc}
     */
    public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode) {
      $image_size = $paragraph->getBehaviorSetting($this->getPluginId(), 'image_size', '4_12');
      $image_position = $paragraph->getBehaviorSetting($this->getPluginId(), 'image_position', 'left');
      $build['#attributes']['class'][] = 'image-size--' . str_replace('_', '-', $image_size);
      $build['#attributes']['class'][] = 'image-position--' . str_replace('_', '-', $image_position);

      if ($build['field_image']['#formatter'] == 'image') {
        switch ($image_size) {
          case '6_12':
            $build['field_image'][0]['#image_style'] = 'image_and_text_6_of_12';
            break;

          case '8_12':
            $build['field_image'][0]['#image_style'] = 'image_and_text_8_of_12';
            break;
        }
      }
    }

    /**
     * {@inheritdoc}
     */
    public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state) {
      $form['image_size'] = [
        '#type' => 'select',
        '#title' => $this->t('Image size'),
        '#options' => $this->getImageSizeOptions(),
        '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'image_size', '4_12'),
      ];

      $form['image_position'] = [
        '#type' => 'select',
        '#title' => $this->t('Image position'),
        '#options' => $this->getImagePositionOptions(),
        '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'image_position', 'left'),
      ];

      return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function settingsSummary(Paragraph $paragraph) {
      $image_size = $paragraph->getBehaviorSetting($this->getPluginId(), 'image_size', '4_12');
      $image_size_options = $this->getImageSizeOptions();
      $image_position = $paragraph->getBehaviorSetting($this->getPluginId(), 'image_position', 'left');
      $image_position_options = $this->getImagePositionOptions();

      $summary = [];
      $summary[] = $this->t('Image size: @value', ['@value' => $image_size_options[$image_size]]);
      $summary[] = $this->t('Image posiion: @value', ['@value' => $image_position_options[$image_position]]);
      return $summary;
    }

    /**
     * Return options for image size.
     */
    private function getImageSizeOptions() {
      return [
        '4_12' => $this->t('4 of 12'),
        '6_12' => $this->t('6 of 12'),
        '8_12' => $this->t('8 of 12'),
      ];
    }

    /**
     * Return options for image position.
     */
    private function getImagePositionOptions() {
      return [
        'left' => $this->t('Left'),
        'right' => $this->t('Right'),
      ];
    }

  }
