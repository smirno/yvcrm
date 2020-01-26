import Axios from 'axios';

var Request = {
    get: function(url, data = null, success = null, error = null) {
        return this.axios(url, 'get', success, error, data);
    },
    post: function(url, data, success = null, error = null) {
        return this.axios(url, 'post', success, error, data);
    },
    put: function(url, data, success = null, error = null) {
        return this.axios(url, 'put', success, error, data);
    },
    delete: function(url, success = null, error = null) {
        return this.axios(url, 'delete', success, error);
    },
    axios: function(url, method, success, error, data = null) {

        Axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        Axios.defaults.headers.common['X-CSRF-Token'] = CSFR;

        var request = {
            url: url,
            method: method
        };

        if (data != null) {
            if (method != 'get') {
                request.data = data;
            } else {
                request.params = data;
            }
        }

        Axios(request).then(function (response) {
            var response = response.data;
            if (response != null) {

                if (response.csrf) {
                    CSFR = response.csrf;
                }

                if (response.status) {
                    if (success != null) {
                        return success(response.data);
                    }
                } else {
                    if (error != null) {
                        return error(response);
                    }
                }

            }
        }).catch(function (response) {
            console.log('Something went wrong!');
            console.log(response);
        });
    }
}

export default Request;