import FormatMessage from 'format-message';

var I18N = {
    language: false,
    messages: {},
    translation: {
        set: function(language) {
            if (language != I18N.language.code) {
                Functions.request.put('/app/translation', {'language': language}, function(responce) {
                    if (responce.language) {
                        document.documentElement.setAttribute('lang', responce.language.code);
                    }
                });
            }
        },
        get: function() {
            Functions.request.get('/app/translation', {}, function(responce) {
                if (responce.language && responce.messages) {

                    I18N.language = responce.language;
                    I18N.messages = responce.messages;

                    Functions.local.set('app-language', I18N.language.code);
                    console.log(I18N.language.name + ' language selected');

                    FormatMessage.setup({
                        locale: I18N.language.code,
                        translations: I18N.messages
                    });
                }
            }, function(responce) {
                I18N.messages = {};
            });
        }
    },
    get: function(message, params = []) {
        return FormatMessage(message, params);
    }
}

export default I18N;