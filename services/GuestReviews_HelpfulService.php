<?php
/**
 * Guest Reviews plugin for Craft CMS
 *
 * Helpful Review Service
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

namespace Craft;

class GuestReviews_HelpfulService extends BaseApplicationComponent
{
    public function totalHelpful($reviewId, $helpful)
    {
        $params = array(
            ':reviewId' => $reviewId,
            ':helpful' => $helpful
        );

        $conditions = array('and',
            'reviewId = :reviewId',
            'helpful = :helpful'
        );

        $totalHelpful = craft()->db->createCommand()
            ->select('COUNT(*)')
            ->from('guestreviews_reviews_helpful')
            ->where($conditions, $params)
            ->queryScalar();

        return $totalHelpful;
    }


    /**
     * @param GuestReviews_ReviewHelpfulModel $helpful
     *
     * @throws \Exception
     * @return bool
     */
    public function saveHelpful(GuestReviews_ReviewHelpfulModel &$helpful)
    {
        // Check if visitor already voted
        $record = $this->_checkIfAllowed($helpful->reviewId, $helpful->helpful, $helpful->ipAddress);

        if ($record) {

            if ($record->helpful == $helpful->helpful) {
                return false;
            } else {
                $helpfulRecord = GuestReviews_ReviewHelpfulRecord::model()->findById($record->id);
                $isNewRecord = false;
            }

        } else {
            $helpfulRecord = new GuestReviews_ReviewHelpfulRecord();
            $isNewRecord = true;
        }

        $helpfulRecord->reviewId    = $helpful->reviewId;
        $helpfulRecord->helpful     = $helpful->helpful;
        $helpfulRecord->ipAddress   = $helpful->ipAddress;
        $helpfulRecord->userAgent   = $helpful->userAgent;

        $helpfulRecord->validate();
        $helpful->addErrors($helpfulRecord->getErrors());

        if (!$helpful->hasErrors()) {
            try {
                $transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;
                
                GuestReviewsPlugin::log('Review Helpful is saved');

                if ($isNewRecord) {
                    $helpfulRecord->id = $helpful->id;
                } else {
                    $helpfulRecord->id = $record->id;
                }
                $helpfulRecord->save(false);

                if ($transaction !== null) {
                    $transaction->commit();
                    GuestReviewsPlugin::log('Transaction Committed');
                }

                $result = array(
                    'isNewRecord' => $isNewRecord,
                    'record' => $helpfulRecord
                );

                return $result;

            } catch (\Exception $e) {
                GuestReviewsPlugin::log('Failed to save element: ' . $e->getMessage());

                return false;
            }
        } else {
            GuestReviewsPlugin::log('Service returns false');

            return false;
        }
    }

    private function _checkIfAllowed($reviewId, $helpful, $ipAddress)
    {
        $params = array(
            ':reviewId' => $reviewId,
            ':ipAddress' => $ipAddress
        ); 

        $conditions = array('and',
            'reviewId = :reviewId',
            'ipAddress = :ipAddress'
        );

        $record = craft()->db->createCommand()
            ->select('*')
            ->from('guestreviews_reviews_helpful')
            ->where($conditions, $params)
            ->queryRow();

        return $record ? GuestReviews_ReviewHelpfulModel::populateModel($record) : null;
    }

}