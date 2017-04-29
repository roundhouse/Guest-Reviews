<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews Widget
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */
namespace Craft;
class GuestReviewsWidget extends BaseWidget
{
    /**
     * @return mixed
     */
    public function getName()
    {
        return Craft::t('Guest Reviews');
    }
    /**
     * @return mixed
     */
    public function getBodyHtml()
    {
        // Include our Javascript & CSS
        craft()->templates->includeCssResource('guestreviews/css/widgets/GuestReviewsWidget.css');
        craft()->templates->includeJsResource('guestreviews/js/widgets/GuestReviewsWidget.js');
        /* -- Variables to pass down to our rendered template */
        $variables = array();
        $variables['settings'] = $this->getSettings();
        return craft()->templates->render('guestreviews/widgets/GuestReviewsWidget_Body', $variables);
    }
    /**
     * @return int
     */
    public function getColspan()
    {
        return 1;
    }
    /**
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'someSetting' => array(AttributeType::String, 'label' => 'Some Setting', 'default' => ''),
        );
    }
    /**
     * @return mixed
     */
    public function getSettingsHtml()
    {

/* -- Variables to pass down to our rendered template */

        $variables = array();
        $variables['settings'] = $this->getSettings();
        return craft()->templates->render('guestreviews/widgets/GuestReviewsWidget_Settings',$variables);
    }

    /**
     * @param mixed $settings  The Widget's settings
     *
     * @return mixed
     */
    public function prepSettings($settings)
    {

/* -- Modify $settings here... */

        return $settings;
    }
}