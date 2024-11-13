angular.module('myApp')
    .service('ApiService', ['$http', '$location', function ($http, $location) {
        // Add sharedserivices
        this.backButton = false;

        var baseUrl = sessionStorage.getItem('baseUrl');
        var apiUrl = baseUrl + '/customer/api/'; // Update to the correct path

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
        this.addToCart = function (varId, quantity) {
            return $http.get(apiUrl + 'cartAdd.php?varId=' + varId + '&value=' + quantity)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };


        this.getCart = function () {
            return $http.get(apiUrl + 'cartList.php')
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };

        this.updateCart = function (varId, quantity) {
            return $http.get(apiUrl + 'cartUpdate.php?varId=' + varId + '&value=' + quantity)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };

        this.submitOrder = function (storeCode, name, Id, notes) {
            return $http.get(apiUrl + 'cartPlaceOrder.php?storeCode=' + storeCode + '&name=' + name + '&Id=' + Id + '&notes=' + notes)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };






        // ===============================================

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

        this.deleteCategory = function (categoryId) {
            return $http.get(apiUrl + 'categoryDelete.php?Id=' + categoryId)
                .then(function (response) {
                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
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

        this.deleteItem = function (itemId) {
            return $http.get(apiUrl + 'itemDelete.php?Id=' + itemId)
                .then(function (response) {
                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };


        this.getItems = function (key, value, storeCode) {
            return $http.get(apiUrl + 'itemList.php?key=' + key + '&value=' + value + '&storeCode=' + storeCode)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };

        this.getVouchers = function (storeCode) {
            return $http.get(apiUrl + 'voucherList.php?storeCode=' + storeCode)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };

        this.saveVoucher = function (data) {
            var formData = new FormData();
            formData.append("storeCode", data.storeCode);
            formData.append("Id", data.Id);
            formData.append("name", data.name);
            formData.append("type", data.type);
            formData.append("minimumSpend", data.minimumSpend);
            formData.append("quantity", data.quantity);
            formData.append("validUntil", data.validUntilFormatted);
            formData.append("status", data.status);
            return $http.post(apiUrl + 'voucherSave.php', formData, {
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


        this.deleteVoucher = function (itemId) {
            return $http.get(apiUrl + 'voucherDelete.php?Id=' + itemId)
                .then(function (response) {
                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };


        this.getFeedbacks = function (storeCode) {
            return $http.get(apiUrl + 'feedbackList.php?storeCode=' + storeCode)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };

        this.getPendingOrders = function (storeCode) {
            return $http.get(apiUrl + 'ordersPending.php?storeCode=' + storeCode)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };

        this.getReports = function (storeCode) {
            return $http.get(apiUrl + 'reportList.php?storeCode=' + storeCode)
                .then(function (response) {

                    console.log('fetching data:', response.data);
                    return response.data;
                })
                .catch(function (error) {
                    console.error('Error fetching data:', error);
                });
        };



    }]);