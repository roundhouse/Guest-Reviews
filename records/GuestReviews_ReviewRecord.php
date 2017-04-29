<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews_Review Record
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ReviewRecord extends BaseRecord
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return 'guestreviews_reviews';
    }

    /**
     * @access protected
     * @return array
     */
   protected function defineAttributes()
    {
        return array(
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
            'userAgent'         => AttributeType::Mixed
        );
    }

    /**
     * Define validation rules
     *
     * @return array
     */
    public function rules()
    {
        return array(
            array(
                'title,review,productId,name,email,overallRating,terms',
                'required'
            )
        );
    }

    /**
     * @return array
     */
    public function defineRelations()
    {
        return array(
            'element'   => array(static::BELONGS_TO, 'ElementRecord', 'id', 'required' => true, 'onDelete' => static::CASCADE),
            'statusId'  => [static::BELONGS_TO, 'GuestReviews_ReviewStatusRecord', 'statusId', 'required' => true, 'onDelete' => static::CASCADE],
        );
    }
}