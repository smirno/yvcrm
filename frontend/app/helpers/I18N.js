import Formatter from './Formatter';
import Local from './Local';
import Request from './Request';

var I18N = {
    language: false,
    messages: {},
    translation: {
        set: function(language) {
            if (language != I18N.language.code) {
                Request.put('/app/translation', {'language': language}, function(responce) {
                    if (responce.language) {
                        document.documentElement.setAttribute('lang', responce.language.code);
                    }
                });
            }
        },
        get: function() {
            Request.get('/app/translation', {}, function(responce) {
                if (responce.language && responce.messages) {

                    I18N.language = responce.language;
                    I18N.messages = responce.messages;

                    Local.set('language', I18N.language.code);
                    console.log(I18N.language.name + ' language selected');

                    Formatter.setup({
                        locale: I18N.language.code,
                        translations: I18N.messages
                    });
                }
            }, function() {
                I18N.messages = {};
            });
        }
    },
    get: function(message, params = []) {
        return Formatter(message, params);
    }
}

export default I18N;