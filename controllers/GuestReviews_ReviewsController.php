<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews Controller
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ReviewsController extends BaseController
{

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     * @access protected
     */
    protected $allowAnonymous = array(
        'actionIndexTemplate',
        'actionSaveReview',
        'actionReportReview',
    );

    public $product;

    public $review;

    /**
     * Index Template
     */
    public function actionIndexTemplate(array $variables = array())
    {
        $variables['reviews'] = gr()->reviews->getAllReviews();

        $this->renderTemplate('guestreviews/reviews/', $variables);
    }


    

    public function actionSaveReview($review = null)
    {
        $this->requirePostRequest();
        $post = craft()->request->post;

        $this->product = craft()->commerce_products->getProductById(craft()->request->getRequiredPost('productId'));

        if (!isset($this->product)) {
            throw new Exception(Craft::t('No product exists with the ID “{id}”', array('id' => $productId)));
        }
        
        if (!$review) {
            $review = $this->_getReviewModel();
            $review = GuestReviews_ReviewModel::populateModel($post);
            $this->_populateReviewModel($review, $post);
        }

        if (gr()->reviews->saveReview($review)) {
            craft()->userSession->setNotice(Craft::t('Review submitted.'));
            $this->redirectToPostedUrl($review);
        } else {
            $this->_redirectOnError($review);
        }
    }

    public function actionReportReview()
    {
        $this->requirePostRequest();
        $reviewId = craft()->request->getRequiredPost('reviewId');

        if (gr()->reviews->reportReview($reviewId)) {
            $this->returnJson(
                array(
                    'success' => true
                )
            );
        } else {
            $this->returnJson(
                array(
                    'success' => false
                )
            );
        }

    }

    /**
     * Create a GuestEntries_ReviewModel
     *
     * @access private
     * @throws Exception
     * @return GuestEntries_ReviewModel
     */
    private function _getReviewModel()
    {
        $review = new GuestReviews_ReviewModel();

        return $review;

    }

    /**
     * Populate a GuestReviews_ReviewModel with post data
     *
     * @access private
     *
     * @param GuestReviews_ReviewModel $review
     */
    private function _populateReviewModel(GuestReviews_ReviewModel $review, array $post = null)
    {
        if (isset($post['terms']) && $post['terms'] == 'on') {
            $review->terms = true;
        }

        if (isset($post['productRecommend']) && $post['productRecommend'] == 'on') {
            $review->productRecommend = true;
        }

        if (isset($post['overallRating'])) {
            $review->overallRating = (int)$post['overallRating'];
        }

        if (isset($post['qualityRating'])) {
            $review->qualityRating = (int)$post['qualityRating'];
        }

        if (isset($post['valueRating'])) {
            $review->valueRating = (int)$post['valueRating'];
        }

        $review->productId      = $this->product->id;
        $review->statusId       = 1;

        $review->ipAddress      = craft()->request->getUserHostAddress();
        $review->userAgent      = craft()->request->getUserAgent();

    }

    /**
     * Error redirects for reviews
     *
     * @param GuestReviews_ReviewModel $review
     */
    private function _redirectOnError(GuestReviews_ReviewModel $review)
    {
        $errors = json_encode($review->getErrors());
        GuestReviewsPlugin::log("Couldn’t save review entry. Errors: ".$errors, LogLevel::Error, true);

        if (craft()->request->isAjaxRequest()) {
            $this->returnJson(
                array(
                    'errors' => $review->getErrors()
                )
            );
        } else {
            craft()->urlManager->setRouteVariables(
                array(
                    'review' => $review
                )
            );
        }
    }
}