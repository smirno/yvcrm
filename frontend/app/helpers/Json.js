var Json = {
    encode: function(object) {
        return JSON.stringify(object, function(key, value) {
            if (typeof value === 'function') {
                return undefined;
            }
            return value;
        });
    },
    decode: function(object) {
        return JSON.parse(object);
    },
    check: function(string) {
        try {
            if (typeof JSON.parse(string) === 'object') {
                return true;
            }
        } catch (error) {
            return false;
        }
    }
}

export default Json;