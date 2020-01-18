var Translation = {
    language: false,
    slugs: {},
    translation: {
        set: function() {},
        get: function() {
            Functions.request.get('/app/translation', {}, function(responce) {
                if (responce) {
                    Translation.language = responce.language;
                    Translation.slugs = responce.slugs;

                    console.log('Current language - ' + Translation.language);
                }
            }, function(responce) {
                Translation.slugs = {};
            });
        }
    },
    get: function(slug, found, params) {
        var parts = slug.split('.'),
            slugs = Translation.slugs;

        for (var i = 0; i < parts.length; i++) {
            slugs = slugs[parts[i]];
            if (!slugs) {
                break;
            }
        }

        if (params) {
            if (typeof slugs != 'string' && typeof slugs != 'object') {
                slugs = found;
            }

            return Translation.replace(params, slugs);
        } else {
            if (typeof slugs == 'string' || typeof slugs == 'object') {
                return slugs;
            }
        }

        return found;
    },
    replace: function(params, subject) {
        var search = Object.keys(params).map(function(param) {
            return '{' + param + '}';
        });

        return Translation.stringReplace(search, Object.values(params), subject);
    },
    stringReplace: function(search, replace, subject, countObj) {
        var i = 0, j = 0, temp = '',
            repl = '', sl = 0, fl = 0,
            f = [].concat(search),
            r = [].concat(replace),
            s = subject,
            ra = Object.prototype.toString.call(r) === '[object Array]',
            sa = Object.prototype.toString.call(s) === '[object Array]';

        s = [].concat(s);

        var $global = (typeof window !== 'undefined' ? window : global);
        $global.$locutus = $global.$locutus || {};
        var $locutus = $global.$locutus;
        $locutus.php = $locutus.php || {};

        if (typeof (search) === 'object' && typeof (replace) === 'string') {
            temp = replace;
            replace = [];
            for (i = 0; i < search.length; i += 1) {
                replace[i] = temp;
            }
            temp = '';
            r = [].concat(replace);
            ra = Object.prototype.toString.call(r) === '[object Array]';
        }

        if (typeof countObj !== 'undefined') {
            countObj.value = 0;
        }

        for (i = 0, sl = s.length; i < sl; i++) {
            if (s[i] === '') {
                continue;
            }
            for (j = 0, fl = f.length; j < fl; j++) {
                temp = s[i] + '';
                repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
                s[i] = (temp).split(f[j]).join(repl);
                if (typeof countObj !== 'undefined') {
                    countObj.value += ((temp.split(f[j])).length - 1);
                }
            }
        }

        return sa ? s : s[0];
    }
};

export default Translation;