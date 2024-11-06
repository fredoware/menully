angular.module('myApp')
    .service('ApiService', ['$http', '$location', function ($http, $location) {
        var baseUrl = sessionStorage.getItem('baseUrl');
        var apiUrl = baseUrl + '/seller/api/'; // Update to the correct path

        this.getData = function () {
            return $http.get(apiUrl + 'data.php')
                .then(function (response) {
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };

        this.postData = function (data) {
            return $http.post(apiUrl + 'another.php', data)
                .then(function (response) {
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error posting data:', error);
                });
        };

        // ==============================================

        this.getOrderData = function (storeCode, status) {
            return $http.get(apiUrl + 'orderList.php?storeCode=' + storeCode + '&status=' + status)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };

        this.markOrderAsPaid = function (itemId, isPaid) {
            return $http.get(apiUrl + 'orderMarkAsPaid.php?itemId=' + itemId + '&isPaid=' + isPaid)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };

        this.changeOrderStatus = function (itemId, status) {
            return $http.get(apiUrl + 'orderChangeStatus.php?itemId=' + itemId + '&status=' + status)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };


        this.getCategories = function (storeCode) {
            return $http.get(apiUrl + 'categoryList.php?storeCode=' + storeCode)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };

        this.saveCategory = function (data) {
            var formData = new FormData();
            formData.append("storeCode", data.storeCode);
            formData.append("Id", data.Id);
            formData.append("name", data.name);
            formData.append("description", data.description);
            formData.append("image", data.image); // Add text input
            return $http.post(apiUrl + 'categorySave.php', formData, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            })
                .then(function (response) {
                    console.log("return data", response);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error posting data:', error);
                });
        };

        this.saveItem = function (data, varations) {
            var formData = new FormData();
            formData.append("storeCode", data.storeCode);
            formData.append("catId", data.catId);
            formData.append("Id", data.Id);
            formData.append("name", data.name);
            formData.append("description", data.description);
            formData.append("image", data.image);
            formData.append("isAvailable", data.isAvailable);
            formData.append("isBestSeller", data.isBestSeller);
            formData.append("varations", JSON.stringify(varations));

            return $http.post(apiUrl + 'itemSave.php', formData, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            });
        };


        this.getItems = function (catId) {
            return $http.get(apiUrl + 'itemList.php?Id=' + catId)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };


    }]);