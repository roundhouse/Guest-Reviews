<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * Guest Reviews Twig Extension
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class GuestReviewsTwigExtension extends \Twig_Extension
{
    /**
     * @return string The extension name
     */
    public function getName()
    {
        return 'GuestReviews';
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            'timeAgo' => new \Twig_Filter_Method($this, 'timeAgoFunction'),
        );
    }

    /**
    * @return array
     */
    // public function getFunctions()
    // {
        // return array(
            // 'timeAgoFunction' => new \Twig_Function_Method($this, 'someInternalFunction'),
        // );
    // }

    /**
     * @return string
     */
    public function timeAgoFunction($datetime, $options = array())
    {
        $options = [
            'format' => 'm/d/Y'
        ];

        return DateTimeHelper::timeAgoInWords($datetime, $options);
    }
}