import Json from './Json';

var Functions = {
    compare: function(obj1, obj2) {
        for (var p in obj1) {
            if (obj1.hasOwnProperty(p) !== obj2.hasOwnProperty(p)) return false;

            switch (typeof (obj1[p])) {
                case 'object':
                    if (!this.compare(obj1[p], obj2[p])) return false;
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
        return Json.decode(Json.encode(obj));
    },
    theme: function(theme = false) {
        if (theme) {
            if (['dark-mode', 'light-mode'].includes(theme)) {
                return document.documentElement.setAttribute('theme', theme);
            }
        } else {
            return document.documentElement.getAttribute('theme');
        }
    }
}

export default Functions;