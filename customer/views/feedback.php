<div ng-controller="FeedbackController">
    
<div class="category-name text-center">Customer's feedback</div>
<div class="text-center">"We value your opinion—share your feedback with us to help improve your experience!"</div>


<div class="stars text-center mt-3">
        <span ng-repeat="star in stars track by $index"
              ng-class="{'selected': $index < rating}"
              ng-mouseenter="hoverRating($index + 1)"
              ng-mouseleave="resetHover()"
              ng-click="setRating($index + 1)">
            &#9733;
        </span>
    </div>
    <p class="text-center">You rated: {{ rating }} star{{ rating > 1 ? 's' : '' }}</p>

    <b class="mt-3">Feedback</b>
    <textarea class="form-control" ng-model="feedback"></textarea>

    <button class="btn btn-primary mt-3" ng-click="submitFeedback()">Submit</button>
    
</div>