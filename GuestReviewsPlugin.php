<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * Manager guest reviews for entries, assets and commerce products
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviewsPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
        parent::init();

    }

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
    public function getDescription()
    {
        return Craft::t('Manage reviews for commerce products');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/roundhouse/guestreviews/blob/master/README.md';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/roundhouse/guestreviews/master/releases.json';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'Vadim Goncharov';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'http://roundhouseagency.com/';
    }

    /**
     * @return bool
     */
    public function hasCpSection()
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function addTwigExtension()
    {
        Craft::import('plugins.guestreviews.twigextensions.GuestReviewsTwigExtension');

        return new GuestReviewsTwigExtension();
    }

    /**
     */
    public function onBeforeInstall()
    {
    }

    /**
     */
    public function onAfterInstall()
    {
        gr()->installDefaultReviewStatuses();
    }

    /**
     */
    public function onBeforeUninstall()
    {
    }

    /**
     */
    public function onAfterUninstall()
    {
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
       return craft()->templates->render('guestreviews/GuestReviews_Settings', array(
           'settings' => $this->getSettings()
       ));
    }

    /**
     * @return mixed
     */
    public function prepSettings($settings)
    {
        // Modify $settings here...

        return $settings;
    }

    /**
     * @return array
     */
    public function registerCpRoutes()
    {
        return array(
            'guestreviews' => array('action' => 'guestReviews/reviews/indexTemplate'),
        );
    }

    /**
     * @return array
     */
    public function registerUserPermissions()
    {
        return array(
            'editReviews' => array(
                'label' => Craft::t('Edit Reviews')
            )
        );
    }
}

/**
 * @return GuestReviewsService
 */
function gr()
{
    return Craft::app()->getComponent('guestReviews');
}