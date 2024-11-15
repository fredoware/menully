angular.module('myApp')
    .controller('ReportController', ['$scope', 'ApiService', function ($scope, ApiService) {
        var storeCode = sessionStorage.getItem('storeCode');

        // Sample data for sales by products
        $scope.productLabels = ['Coffee', 'Coke', 'Burger', 'Pizza'];
        $scope.productSalesData = [120, 150, 180, 90];

        // Sample data for sales by category
        $scope.categoryLabels = ['Category 1', 'Category 2', 'Category 3'];
        $scope.categorySalesData = [300, 500, 200];


        // const obj = { "0": "aac", "1": "asa", "2": "aaa", "3": "ada" };

        // // Convert to [0, 1, 2, 3] (keys as an array)
        // const keys = Object.keys(obj).map(Number);  // Convert string keys to numbers
        // console.log(keys); // Output: [0, 1, 2, 3]

        // // Convert to ["aac", "asa", "aaa", "ada"] (values as an array)
        // const values = Object.values(obj);
        // console.log(values); // Output: ["aac", "asa", "aaa", "ada"]


        $scope.fetchData = function () {
            $scope.spinner(true);
            ApiService.getReports(storeCode).then(function (data) {
                console.log("report list", data);
                // $scope.categoryList = data.list;
                $scope.productLabels = data.productLabels
                $scope.productSalesData = data.productData
                $scope.spinner(false);
            });
        };

        // Initial data fetch
        $scope.fetchData();


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