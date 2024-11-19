<div ng-controller="ReportController">

<div class="category-name text-center">Sales Reports</div>


<!-- Product Sales Chart -->
<div class="chart-container">
    <canvas chart-directive chart-data="productSalesData" chart-labels="productLabels" chart-title="'Sales by Product'"></canvas>
</div>


<!-- Category Sales Chart -->
<div class="chart-container">
    <canvas chart-directive chart-data="categorySalesData" chart-labels="categoryLabels" chart-title="'Sales by Category'"></canvas>
</div>



</div>