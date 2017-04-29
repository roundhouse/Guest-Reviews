<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews_Review ElementType
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ReviewElementType extends BaseElementType
{
    /**
     * @return mixed
     */
    public function getName()
    {
        return Craft::t('Guest Reviews');
    }

    /**
     * @return bool
     */
    public function hasContent()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function hasTitles()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function hasStatuses()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isLocalized()
    {
        return false;
    }

    /**
     * @param string|null $context
     * @return array|false
     */
    public function getSources($context = null)
    {
    }

    /**
     * @inheritDoc IElementType::getAvailableActions()
     *
     * @param string|null $source
     *
     * @return array|null
     */
    public function getAvailableActions($source = null)
    {
    }

    /**
     * @return array
     */
    public function defineAvailableTableAttributes()
    {
        $attributes = array(
            'title'     => array('label' => Craft::t('Title')),
            'review'     => array('label' => Craft::t('Review')),
            'name'     => array('label' => Craft::t('Name')),
            'location'     => array('label' => Craft::t('Location')),
        );

        return $attributes;

    }

    /**
     * @param string|null $source
     * @return array
     */
    public function defineTableAttributes($source = null)
    {
    }

    /**
     * @param BaseElementModel $element
     * @param string $attribute
     * @return string
     */
    public function getTableAttributeHtml(BaseElementModel $element, $attribute)
    {
    }

    /**
     * @return array
     */
    public function defineCriteriaAttributes()
    {
    }

    /**
     * @param DbCommand $query
     * @param ElementCriteriaModel $criteria
     * @return mixed
     */
    public function modifyElementsQuery(DbCommand $query, ElementCriteriaModel $criteria)
    {
   }

    /**
     * @param array $row
     * @return array
     */
    public function populateElementModel($row)
    {
    }

    /**
     * @param BaseElementModel $element
     * @return string
     */
    public function getEditorHtml(BaseElementModel $element)
    {
    }
}