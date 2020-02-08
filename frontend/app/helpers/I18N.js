import Formatter from './Formatter';

var I18N = {
    language: false,
    messages: {},
    translation: {
        set: function(translation) {
            if (translation != undefined) {
                I18N.language = translation.language;
                I18N.messages = translation.messages;

                console.log(I18N.language.name + ' language selected');

                Formatter.setup({
                    locale: I18N.language.code,
                    translations: I18N.messages,
                    missingTranslation: 'ignore'
                });
            }
        }
    },
    get: function(message, params = []) {
        return Formatter(message, params);
    }
}

export default I18N;