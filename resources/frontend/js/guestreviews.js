(function($) {
  window.ReviewItem = Garnish.Base.extend({
    $el: null,
    $reportBtn: null,
    reportBtnText: null,
    reviewId: null,
    reportAction: '/actions/guestReviews/reviews/reportReview',
    init: function(el) {
      var helpfulElement;
      this.$el = $(el);
      this.$reportBtn = this.$el.find('.gr-report-action');
      this.reportBtnText = this.$reportBtn.find('.gr-report-text');
      this.reviewId = this.$el.data('review-id');
      helpfulElement = this.$el.find('.gr-helpful-block');
      new window.HelpfulReview(helpfulElement, this.reviewId);
      return this.addListener(this.$reportBtn, 'click', 'processReportReview');
    },
    processReportReview: function(e) {
      var data, self;
      e.preventDefault();
      self = this;
      data = {
        'reviewId': this.reviewId
      };
      return $.post(this.reportAction, data, function(response) {
        if (response.success) {
          self.$reportBtn.addClass('gr-reported');
          return self.reportBtnText.html('Reported');
        }
      });
    }
  });
  return window.HelpfulReview = Garnish.Base.extend({
    $el: null,
    $yesBtn: null,
    $noBtn: null,
    yesCount: null,
    noCount: null,
    saveHelpfulAction: '/actions/guestReviews/helpful/saveHelpful',
    reviewId: null,
    init: function(el, reviewId) {
      this.$el = $(el);
      this.reviewId = reviewId;
      this.$yesBtn = this.$el.find('.gr-helpful-action-yes');
      this.$noBtn = this.$el.find('.gr-helpful-action-no');
      this.yesCount = this.$yesBtn.find('.gr-yes-count');
      this.noCount = this.$noBtn.find('.gr-no-count');
      this.addListener(this.$yesBtn, 'click', 'processHelpful');
      return this.addListener(this.$noBtn, 'click', 'processNotHelpful');
    },
    processHelpful: function(e) {
      e.preventDefault();
      return this.processHelpfulSubmission(1);
    },
    processNotHelpful: function(e) {
      e.preventDefault();
      return this.processHelpfulSubmission(0);
    },
    processHelpfulSubmission: function(helpful) {
      var data, self;
      self = this;
      data = {
        'helpful': helpful,
        'reviewId': this.reviewId
      };
      return $.post(this.saveHelpfulAction, data, function(response) {
        var noCount, yesCount;
        yesCount = parseInt(self.yesCount.html());
        noCount = parseInt(self.noCount.html());
        if (response.success) {
          if (response.isNewRecord) {
            if (response.helpful) {
              return self.yesCount.html(yesCount + 1);
            } else {
              return self.noCount.html(noCount + 1);
            }
          } else {
            if (response.helpful) {
              self.yesCount.html(yesCount + 1);
              return self.noCount.html(noCount - 1);
            } else {
              self.yesCount.html(yesCount - 1);
              return self.noCount.html(noCount + 1);
            }
          }
        }
      });
    }
  });
})(jQuery);
