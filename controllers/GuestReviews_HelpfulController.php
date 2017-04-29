<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviews_Helpful Controller
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_HelpfulController extends BaseController
{
    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     * @access protected
     */
    protected $allowAnonymous = array(
        'actionSaveHelpful',
    );

    public $response;

    public function actionSaveHelpful()
    {

        $this->requirePostRequest();
        $reviewId   = craft()->request->getRequiredPost('reviewId');
        $helpful    = craft()->request->getRequiredPost('helpful');

        $ipAddress = craft()->request->getUserHostAddress();

        $helpfulModel               = new GuestReviews_ReviewHelpfulModel();
        $helpfulModel->reviewId     = $reviewId;
        $helpfulModel->helpful      = $helpful;
        $helpfulModel->ipAddress    = $ipAddress;
        $helpfulModel->userAgent    = craft()->request->getUserAgent();

        $result = gr()->helpful->saveHelpful($helpfulModel);

        if ($result) {
            $this->returnJson(
                array(
                    'success'       => true,
                    'isNewRecord'   => (int) $result['isNewRecord'],
                    'helpful'       => (int) $result['record']->helpful
                )
            );
        } else {
            $this->returnJson(
                array(
                    'success'   => false
                )
            );
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