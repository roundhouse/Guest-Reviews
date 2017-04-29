<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews_ReviewHelpful Record
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ReviewHelpfulRecord extends BaseRecord
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return 'guestreviews_reviews_helpful';
    }

    /**
     * @access protected
     * @return array
     */
   protected function defineAttributes()
    {
        return array(
            'reviewId'          => array(AttributeType::Number, 'required' => true),
            'helpful'           => array(AttributeType::Bool, 'required' => true),
            'ipAddress'         => array(AttributeType::String, 'required' => true),
            'userAgent'         => array(AttributeType::Mixed, 'required' => true)
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
                'reviewId,helpful,ipAddress,userAgent',
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
            'review' => array(static::BELONGS_TO, 'GuestReviews_ReviewRecord', 'required' => true, 'onDelete' => static::CASCADE)
        );
    }
}