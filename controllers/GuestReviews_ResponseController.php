<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews_Response Controller
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ResponseController extends BaseController
{
    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     * @access protected
     */
    protected $allowAnonymous = array(
        'actionIndexTemplate',
        'actionSaveResponse',
    );

    public $response;

    public $user;


    public function actionSaveResponse()
    {
        $this->requirePostRequest();
        $post = craft()->request->post;
        $reviewId           = craft()->request->getRequiredPost('reviewId');
        $userId             = craft()->request->getRequiredPost('userId');
        $responseMessage    = craft()->request->getRequiredPost('responseMessage');

        $this->user = craft()->users->getUserById($userId);

        $response = new GuestReviews_ReviewResponseModel();
        $response->reviewId = (int) $reviewId;
        $response->userId = (int) $userId;
        $response->responseMessage = $responseMessage;
        // $response = GuestReviews_ReviewResponseModel::populateModel($post);

        if (gr()->response->saveResponse($response)) {
            craft()->userSession->setNotice(Craft::t('Response submitted.'));
            $this->redirectToPostedUrl($response);
        } else {
            $this->_redirectOnError($response);
        }
    }

    /**
     * Error redirects for response
     *
     * @param GuestReviews_ReviewResponseModel $response
     */
    private function _redirectOnError(GuestReviews_ReviewResponseModel $response)
    {
        $errors = json_encode($response->getErrors());
        GuestReviewsPlugin::log("Couldn’t save response entry. Errors: ".$errors, LogLevel::Error, true);

        if (craft()->request->isAjaxRequest()) {
            $this->returnJson(
                array(
                    'errors' => $response->getErrors()
                )
            );
        } else {
            craft()->urlManager->setRouteVariables(
                array(
                    'response' => $response
                )
            );
        }
    }
}