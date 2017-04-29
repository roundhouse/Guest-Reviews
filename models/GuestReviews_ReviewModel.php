<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews_Review Model
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ReviewModel extends BaseElementModel
{
    protected $elementType = 'GuestReviews_Review';

    public $totalHelpful;
    public $totalNotHelpful;

    /**
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'title'             => AttributeType::String,
            'review'            => AttributeType::Mixed,
            'photos'            => AttributeType::Mixed,
            'productId'         => AttributeType::Number,
            'productRecommend'  => AttributeType::Bool,
            'name'              => AttributeType::String,
            'location'          => AttributeType::String,
            'email'             => AttributeType::String,
            'age'               => AttributeType::String,
            'gender'            => AttributeType::String,
            'overallRating'     => AttributeType::Number,
            'qualityRating'     => AttributeType::Number,
            'valueRating'       => AttributeType::Number,
            'terms'             => array(AttributeType::Bool, 'required' => true),
            'yesCount'          => array(AttributeType::Number, 'default' => 0),
            'noCount'           => array(AttributeType::Number, 'default' => 0),
            'reported'          => array(AttributeType::Bool, 'default' => false),
            'statusId'          => AttributeType::Number,
            'ipAddress'         => AttributeType::String,
            'userAgent'         => AttributeType::Mixed,
        ));
    }

}