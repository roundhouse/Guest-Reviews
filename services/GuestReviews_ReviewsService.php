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

class GuestReviews_ReviewsService extends BaseApplicationComponent
{

    private $_reviewsById;
    private $_allReviewIds;
    private $_fetchedAllReviews = false;

    public function getReviewById($reviewId)
    {
        if (!isset($this->_reviewsById) || !array_key_exists($reviewId, $this->_reviewsById)) {
            $reviewRecord = GuestReviews_ReviewRecord::model()->findById($reviewId);

            if ($reviewRecord) {
                $this->_reviewsById[$reviewId] = GuestReviews_ReviewModel::populateModel($reviewRecord);
            } else {
                $this->_reviewsById[$reviewId] = null;
            }
        }

        return $this->_reviewsById[$reviewId];
    }


    public function getReviewsByProductId($productId)
    {
        // $product = craft()->commerce_products->getProductById($productId);
        $reviews = craft()->db->createCommand()
            ->select('*')
            ->from('guestreviews_reviews')
            ->where('productId=:id', [':id' => $productId])
            // ->order('sortOrder asc')
            ->queryAll();

        return GuestReviews_ReviewModel::populateModels($reviews);
    }  

    // 
    // Report a review
    // 
    public function reportReview($reviewId)
    {
        $reviewRecord = GuestReviews_ReviewRecord::model()->findById($reviewId);

        if ($reviewRecord) {
            $reviewRecord->setAttribute('reported', 1);

            return $reviewRecord->save();
        } else {
            return false;
        }


        // if (!$review->hasErrors()) {
        //     try {
        //         $transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;

        //         $success = craft()->elements->saveElement($review);

        //         if ($success) {
        //             GuestReviewsPlugin::log('Review is Reported: ' . $success);

        //             $reviewRecord->save(false);

        //             if (!$review->id) { 
        //                 $review->id = $reviewRecord->id; 
        //             }

        //             $this->_reviewsById[$review->id] = $review;

        //             if ($transaction !== null) {
        //                 $transaction->commit();
        //                 GuestReviewsPlugin::log('Transaction Committed');
        //             }

        //             return true;
        //         } else {
        //             GuestReviewsPlugin::log('Cannot save element', LogLevel::Error, true);
        //         }
        //     } catch (\Exception $e) {
        //         GuestReviewsPlugin::log('Failed to save element: ' . $e->getMessage());

        //         return false;
        //     }
        // } else {
        //     GuestReviewsPlugin::log('Service returns false');

        //     return false;
        // }
    }

    /**
     * @param GuestReviews_ReviewModel $review
     *
     * @throws \Exception
     * @return bool
     */
    public function saveReview(GuestReviews_ReviewModel &$review)
    {
        $reviewRecord = new GuestReviews_ReviewRecord();
        $reviewRecord->setAttributes($review->attributes, false);

        $reviewRecord->validate();
        $review->addErrors($reviewRecord->getErrors());

        if (!$review->hasErrors()) {
            try {
                $transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;

                $success = craft()->elements->saveElement($review);

                if ($success) {
                    GuestReviewsPlugin::log('Review is saved: ' . $success);

                    $reviewRecord->id = $review->id;
                    $reviewRecord->save(false);

                    if ($transaction !== null) {
                        $transaction->commit();
                        GuestReviewsPlugin::log('Transaction Committed');
                    }

                    return true;
                } else {
                    GuestReviewsPlugin::log('Cannot save element', LogLevel::Error, true);
                }
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