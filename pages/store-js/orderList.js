class Order {
  constructor($scope, $http, storeCode) {
    this.$scope = $scope;
    this.$http = $http;
    this.storeCode = storeCode;
  }

  orderList(status){
    this.$scope.pageSpinner = true;
    this.$http({
      method: "GET",
      url: '../pages/api-store.php?action=order-list',
      params: {
        'storeCode': this.storeCode,
        'status': status,
      },
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
      }
    }).then(function mySuccess(response) {
      this.$scope.orderList = response.data;
      this.$scope.pageSpinner = false;
    }, function myError(response) {
      console.log("Validation", response.statusText)
    });
  }


}

// function orderList($http, $scope, storeCode, status) {
// $scope.pageSpinner = true;
// $http({
//   method: "GET",
//   url: '../pages/api-store.php?action=order-list',
//   params: {
//     'storeCode': storeCode,
//     'status': status,
//   },
//   headers: {
//       'Content-Type': 'application/x-www-form-urlencoded'
//   }
// }).then(function mySuccess(response) {
//   $scope.orderList = response.data;
//   $scope.pageSpinner = false;
// }, function myError(response) {
//   console.log("Validation", response.statusText)
// });


  // }
