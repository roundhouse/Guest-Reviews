<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews_ReviewStatus Record
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ReviewStatusRecord extends BaseRecord
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return 'guestreviews_reviews_statuses';
    }

    /**
     * @access protected
     * @return array
     */
   protected function defineAttributes()
    {
        return array(
            'name'          => array(AttributeType::String, 'required' => true),
            'handle'        => array(AttributeType::Handle, 'required' => true),
            'color'         => array(AttributeType::Enum,
                'values'    => array('orange', 'green', 'red', 'gray', 'black'),
                'required'  => true,
                'default'   => 'orange'
            ),
            'sortOrder'     => AttributeType::SortOrder,
            'isDefault'     => array(AttributeType::Bool, 'default' => 0)
        );
    }
}