import Json from './Json';

var Local =  {
    prefix: 'app-',
    set: function(slug, data) {
        if (typeof data !== 'string') {
            data = Json.encode(data);
        }
        return localStorage.setItem(this.prefix + slug, data);
    },
    get: function(slug) {
        var local = localStorage.getItem(this.prefix + slug);
        if (local) {
            if (Json.check(local)) {
                local = Json.decode(local)
            }

            return local;
        }
        return false;
    },
    clear: function(slug) {
        return localStorage.removeItem(this.prefix + slug);
    }
}

export default Local;