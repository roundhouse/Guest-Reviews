<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * Response Service
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_ResponseService extends BaseApplicationComponent
{

    public function getReviewResponse($reviewId)
    {
        $response = craft()->db->createCommand()
            ->select('*')
            ->from('guestreviews_reviews_response')
            ->where('reviewId=:id', [':id' => $reviewId])
            ->queryRow();

        return $response ? GuestReviews_ReviewResponseModel::populateModel($response) : null;
    } 


    /**
     * @param GuestReviews_ReviewResponseModel $response
     *
     * @throws \Exception
     * @return bool
     */
    public function saveResponse(GuestReviews_ReviewResponseModel &$response)
    {
        $responseRecord = new GuestReviews_ReviewResponseRecord();
        $responseRecord->reviewId = $response->reviewId;
        $responseRecord->userId = $response->userId;
        $responseRecord->responseMessage = $response->responseMessage;
        // $responseRecord->setAttributes($response->attributes, false);

        $responseRecord->validate();
        $response->addErrors($responseRecord->getErrors());

        if (!$response->hasErrors()) {
            try {
                $transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;
                    GuestReviewsPlugin::log('Response is saved');

                    $responseRecord->id = $response->id;
                    $responseRecord->save(false);

                    if ($transaction !== null) {
                        $transaction->commit();
                        GuestReviewsPlugin::log('Transaction Committed');
                    }

                    return true;

            } catch (\Exception $e) {
                GuestReviewsPlugin::log('Failed to save element: ' . $e->getMessage());

                return false;
            }
        } else {
            GuestReviewsPlugin::log('Service returns false');

            return false;
        }
    }

}