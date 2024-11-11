<div ng-controller="FeedbackController">

    <div class="row">
        <div class="category-name text-center">Customer's feedback</div>
        <div class="col-lg-4 col-md-6 mt-2" ng-repeat="item in feedbackList" data-aos="fade-up">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col order-label">
                            Date:
                        </div>
                        <div class="col order-value">
                            {{item.item.dateAdded}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col order-label">
                            Order Number:
                        </div>
                        <div class="col order-value">
                            {{item.order.orderNumber}}
                        </div>
                    </div>



                    <div class="row">
                        <div class="col order-label" style="">
                            Ratings:
                        </div>
                        <div class="col order-value">
                        <div class="star-rating">
                                    <span ng-repeat="star in getStars()"
                                        ng-class="{'filled': star <= item.item.stars, 'empty': star > item.item.stars}"
                                        class="star"></span>
                                </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col order-label" style="">
                            Customer:
                        </div>
                        <div class="col order-value">
                            {{item.customer.name}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col order-label" style="">
                            Feedback:
                        </div>
                        <div class="col order-value">
                            {{item.item.feedback}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>