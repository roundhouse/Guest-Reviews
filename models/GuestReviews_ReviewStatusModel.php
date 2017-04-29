<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews_ReviewStatus Model
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ReviewStatusModel extends BaseModel
{
    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->name;
    }

    /**
     * @return string
     */
    public function htmlLabel()
    {
        return sprintf('<span class="guestReviewsStatusLabel"><span class="status %s"></span> %s</span>',
            $this->color, $this->name);
    }

    /**
     * @return array
     */
    protected function defineAttributes()
    {
        return array(
            'id'            => AttributeType::Number,
            'name'          => array(AttributeType::String, 'required' => true),
            'handle'        => array(AttributeType::Handle, 'required' => true),
            'color'         => array(AttributeType::Enum, 'default' => 'orange'),
            'sortOrder'     => AttributeType::SortOrder,
            'isDefault'     => array(AttributeType::Bool, 'default' => 0)
        );
    }
}