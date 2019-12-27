var Functions = {
    json: {
        encode: function(obj) {
            return JSON.stringify(obj, function(key, value) {
                if (typeof value === 'function') {
                    return undefined;
                }
                return value;
            });
        },
        decode: function(obj) {
            return JSON.parse(obj);
        }
    },
    local: {
        set: function(id, data) {
            return localStorage.setItem(id, Functions.json.encode(data));
        },
        get: function(id) {
            var local = localStorage.getItem(id);
            if (local) {
                return Functions.json.decode(local);
            }
            return false;
        },
        clear: function(id) {
            return localStorage.removeItem(id);
        }
    }, 
    request: {
        get: function(url, data = null, success = null, error = null) {
            return Functions.request.axios(url, 'get', success, error, data);
        },
        post: function(url, data, success = null, error = null) {
            return Functions.request.axios(url, 'post', success, error, data);
        },
        put: function(url, data, success = null, error = null) {
            return Functions.request.axios(url, 'put', success, error, data);
        },
        delete: function(url, success = null, error = null) {
            return Functions.request.axios(url, 'delete', success, error);
        },
        axios: function(url, method, success, error, data = null) {

            Axios.defaults.headers.common['X-CSRF-Token'] = CSFR;

            var request = {
                url: url,
                method: method
            };

            if (data != null && method != 'get') {
                request.data = {
                    'data': data
                };
            } else if (method == 'get') {
                request.params = data;
            }

            Axios(request).then(function (response) {
                // console.log(response);
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
                console.log('Что то пошло не так!');
                console.log(response);
            });
        }
    },
    compare: function(obj1, obj2) {
        for (var p in obj1) {
            if (obj1.hasOwnProperty(p) !== obj2.hasOwnProperty(p)) return false;

            switch (typeof (obj1[p])) {
                case 'object':
                    if (!Functions.compare(obj1[p], obj2[p])) return false;
                    break;
                case 'function':
                    if (typeof (obj2[p]) == 'undefined' || (p != 'compare' && obj1[p].toString() != obj2[p].toString())) return false;
                    break;
                default:
                    if (obj1[p].trim() != obj2[p].trim()) return false;
            }
        }

        for (var p in obj2) {
            if (typeof (obj1[p]) == 'undefined') return false;
        }
        return true;
    },
    copy: function(obj) {
        return Functions.json.decode(Functions.json.encode(obj));
    },
    declension: function(number, titles) {  
        var cases = [2, 0, 1, 1, 1, 2];  
        return titles[(number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5]];  
    }
};

export default Functions;