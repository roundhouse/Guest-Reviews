<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews_ReviewResponse Record
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ReviewResponseRecord extends BaseRecord
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return 'guestreviews_reviews_response';
    }

    /**
     * @access protected
     * @return array
     */
   protected function defineAttributes()
    {
        return array(
            'reviewId'          => array(AttributeType::Number, 'required' => true),
            'userId'            => array(AttributeType::Number, 'required' => true),
            'responseMessage'   => array(AttributeType::Mixed, 'required' => true)
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
                'reviewId,userId,responseMessage',
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
            'review' => array(static::BELONGS_TO, 'GuestReviews_ReviewRecord', 'required' => true, 'onDelete' => static::CASCADE),
            'user' => array(static::BELONGS_TO, 'UserRecord', 'required' => true, 'onDelete' => static::CASCADE)
        );
    }
}