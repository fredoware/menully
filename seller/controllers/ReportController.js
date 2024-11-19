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

        // const keys = Object.keys(obj); // ["a", "b", "c"]
        // const values = Object.values(obj); // [1, 2, 3]


        // $scope.fetchData = function () {
        //     $scope.spinner(true);
        //     ApiService.getReports(storeCode).then(function (data) {
        //         const labels = data.menuItems.map(item => item.label);
        //         const values = data.menuItems.map(item => item.value);
        //         console.log("report key", labels);
        //         console.log("report value", values);
        //         // $scope.categoryList = data.list;
        //         $scope.productLabels = labels;
        //         $scope.productSalesData = values;
        //         $scope.spinner(false);
        //     });
        // };

        // // Initial data fetch
        // $scope.fetchData();


    }]).directive('echartsBarChart', function () {
        return {
            restrict: 'A',
            scope: {
                chartData: '=',    // Sales data
                chartLabels: '=',  // Labels (e.g., product names)
                chartTitle: '@'    // Title for the chart
            },
            link: function (scope, element) {
                // Initialize the chart
                var chart = echarts.init(element[0]);

                // Watch for changes to the data and labels
                scope.$watchGroup(['chartData', 'chartLabels'], function (newValues) {
                    if (newValues[0] && newValues[1]) {
                        // Configure chart options for a horizontal bar chart
                        var options = {
                            title: {
                                text: scope.chartTitle || 'Sales Bar Chart',
                                left: 'center'
                            },
                            tooltip: {
                                trigger: 'axis',
                                axisPointer: { type: 'shadow' }
                            },
                            grid: {
                                left: '10%',
                                right: '10%',
                                bottom: '10%',
                                containLabel: true
                            },
                            xAxis: {
                                type: 'value', // Horizontal scale (bar width)
                                name: 'Sales Amount',
                                axisLabel: {
                                    formatter: '{value}'
                                }
                            },
                            yAxis: {
                                type: 'category', // Category axis (vertical items)
                                data: scope.chartLabels,
                                axisLabel: {
                                    formatter: function (value) {
                                        return value; // Item names on Y-axis
                                    }
                                }
                            },
                            series: [{
                                type: 'bar',
                                data: scope.chartData,
                                barWidth: '40%', // Adjust bar width
                                itemStyle: { color: '#73C0DE' }
                            }]
                        };

                        // Set the options
                        chart.setOption(options);
                    }
                });

                // Handle responsiveness
                window.addEventListener('resize', function () {
                    chart.resize();
                });

                // Clean up on directive destroy
                scope.$on('$destroy', function () {
                    chart.dispose();
                });
            }
        };
    });