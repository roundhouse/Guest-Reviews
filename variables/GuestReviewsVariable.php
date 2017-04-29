<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * Guest Reviews Variable
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviewsVariable
{
    /**
     * Display Reviews
     */
    public function displayReviews($productId, array $options = null)
    {
        $product = craft()->commerce_products->getProductById($productId);

        if (craft()->request->isSiteRequest() && $product->id) {

            craft()->templates->includeCssResource('guestReviews/frontend/css/guestreviews.css');
            craft()->templates->includeJsResource('lib/garnish.min.js');
            craft()->templates->includeJsResource('guestReviews/frontend/libs/dropdown.js');
            craft()->templates->includeJsResource('guestReviews/frontend/js/guestreviews.js');
            craft()->templates->includeJs('
                var reviewItems = document.querySelectorAll(".gr-review-item");
                [].forEach.call(reviewItems, function(item) {
                    new ReviewItem(item);
                });

                $(".dropdown-toggle").dropdown();
            ');
        }

        $reviews = gr()->reviews->getReviewsByProductId($productId);

        if (!$reviews) {
            return 'No reviews available yet, create one!';
        }

        craft()->templates->setTemplatesPath(craft()->path->getPluginsPath().'guestreviews/templates/');
        $reviewsHtml = craft()->templates->render('frontend/reviews', array(
                'reviews'  => $reviews,
                'options'  => $options
            )
        );
        craft()->templates->setTemplatesPath(craft()->path->getSiteTemplatesPath());

        return TemplateHelper::getRaw($reviewsHtml);
    }

    public function displayReviewsSummary($productId, array $options = null)
    {
        $reviews = gr()->reviews->getReviewsByProductId($productId);

        if (!$reviews) {
            return 'No reviews available yet, create one!';
        }

        $stars_1 = 0;
        $stars_2 = 0;
        $stars_3 = 0;
        $stars_4 = 0;
        $stars_5 = 0;
        foreach ($reviews as $key => $review) {
            if ($review->overallRating == 1) {
                $stars_1 += 1;
            }
            if ($review->overallRating == 2) {
                $stars_2 += 1;
            }
            if ($review->overallRating == 3) {
                $stars_3 += 1;
            }
            if ($review->overallRating == 4) {
                $stars_4 += 1;
            }
            if ($review->overallRating == 5) {
                $stars_5 += 1;
            }
        }

        $total_votes = $stars_1 + $stars_2 + $stars_3 + $stars_4 + $stars_5;

        $average = ($stars_1 + $stars_2 * 2 + $stars_3 * 3 + $stars_4 * 4 + $stars_5 * 5) / $total_votes;

        craft()->templates->setTemplatesPath(craft()->path->getPluginsPath().'guestreviews/templates/');
        $reviewsHtml = craft()->templates->render('frontend/reviews-summary', array(
                'reviews'       => $reviews,
                'options'       => $options,
                'totalVotes'    => $total_votes,
                'average'       => round($average, 1),
                'stars'         => array(
                    'total' => floor($average),
                    'five'  => $stars_5,
                    'four'  => $stars_4,
                    'three' => $stars_3,
                    'two'   => $stars_2,
                    'one'   => $stars_1
                )
            )
        );
        craft()->templates->setTemplatesPath(craft()->path->getSiteTemplatesPath());

        return TemplateHelper::getRaw($reviewsHtml);
    }

    public function displayReviewResponse($reviewId)
    {
        $response = gr()->response->getReviewResponse($reviewId);

        return $response;
    }

    public function totalHelpful($reviewId, $helpful)
    {
        $total = gr()->helpful->totalHelpful($reviewId, $helpful);

        return (string) $total;
    }
}