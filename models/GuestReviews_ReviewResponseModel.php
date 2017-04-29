<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews_ReviewResponse Model
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ReviewResponseModel extends BaseModel
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
            'userId'            => array(AttributeType::Number, 'required' => true),
            'responseMessage'   => array(AttributeType::Mixed, 'required' => true)
        ));
    }
}