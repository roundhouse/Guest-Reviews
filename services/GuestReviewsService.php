<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * Reviews Service
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviewsService extends BaseApplicationComponent
{
    public $reviews;
    public $response;
    public $helpful;

    public function init()
    {
        parent::init();

        $this->reviews = Craft::app()->getComponent('guestReviews_reviews');
        $this->response = Craft::app()->getComponent('guestReviews_response');
        $this->helpful = Craft::app()->getComponent('guestReviews_helpful');
    }


    public function installDefaultReviewStatuses()
    {
        $statuses = array(
            0 => array(
                'name'      => 'Pending',
                'handle'    => 'pending',
                'color'     => 'orange',
                'sortOrder' => 1,
                'isDefault' => 1
            ),
            1 => array(
                'name'      => 'Accepted',
                'handle'    => 'accepted',
                'color'     => 'green',
                'sortOrder' => 2,
                'isDefault' => 0
            ),
            2 => array(
                'name'      => 'Denied',
                'handle'    => 'denied',
                'color'     => 'red',
                'sortOrder' => 3,
                'isDefault' => 0
            ),
            3 => array(
                'name'      => 'Banned',
                'handle'    => 'banned',
                'color'     => 'black',
                'sortOrder' => 4,
                'isDefault' => 0
            ),
            4 => array(
                'name'      => 'Expired',
                'handle'    => 'expired',
                'color'     => 'gray',
                'sortOrder' => 5,
                'isDefault' => 0
            )
        );

        foreach ($statuses as $status)
        {
            craft()->db->createCommand()->insert('guestreviews_reviews_statuses', array(
                'name'      => $status['name'],
                'handle'    => $status['handle'],
                'color'     => $status['color'],
                'sortOrder' => $status['sortOrder'],
                'isDefault' => $status['isDefault']
            ));
        }
    }

    

}