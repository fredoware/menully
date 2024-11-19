<div ng-controller="ReportController">

    <div class="category-name text-center">Sales Reports</div>

    <div class="bar-container">
            <!-- Loop through data and create bars -->
            <div class="bar-item" ng-repeat="item in data" ng-if="item.value>0">
                <div class="bar-label">&nbsp</div>
                <div class="bar" ng-style="{'width': (item.value / 100) * maxBarWidth + 'px'}">
                    <!-- Label directly on the bar -->
                    <div class="bar-value">{{ item.label }}: {{ item.value }}</div>
                </div>
            </div>
        </div>


</div>