<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews_ReviewHelpful Model
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ReviewHelpfulModel extends BaseModel
{
    /**
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'id'                => AttributeType::Number,
            'dateCreated'       => AttributeType::DateTime,
            'reviewId'          => array(AttributeType::Number, 'required' => true),
            'helpful'           => array(AttributeType::Bool, 'required' => true),
            'ipAddress'         => array(AttributeType::String, 'required' => true),
            'userAgent'         => array(AttributeType::Mixed, 'required' => true)
        ));
    }
}