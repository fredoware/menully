angular.module('myApp')
    .controller('ReportController', ['$scope', 'ApiService', function ($scope, ApiService) {


        // Sample data for sales by products
        $scope.productLabels = ['Coffee', 'Coke', 'Burger', 'Pizza'];
        $scope.productSalesData = [120, 150, 180, 90];

        // Sample data for sales by category
        $scope.categoryLabels = ['Category 1', 'Category 2', 'Category 3'];
        $scope.categorySalesData = [300, 500, 200];


    }]).directive('chartDirective', function () {
        return {
            restrict: 'A',
            scope: {
                chartData: '=',
                chartLabels: '=',
                chartTitle: '='
            },
            link: function (scope, element) {
                var ctx = element[0].getContext('2d');

                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: scope.chartLabels,
                        datasets: [{
                            label: scope.chartTitle,
                            data: scope.chartData,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false // Disable the legend display
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Sales Amount'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: scope.chartTitle.includes('Product') ? 'Products' : 'Categories'
                                }
                            }
                        }
                    }
                });

                // Update the chart when data changes
                scope.$watchGroup(['chartData', 'chartLabels'], function (newValues, oldValues) {
                    if (newValues !== oldValues) {
                        chart.data.labels = scope.chartLabels;
                        chart.data.datasets[0].data = scope.chartData;
                        chart.update();
                    }
                });
            }
        };
    });