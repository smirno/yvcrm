var Language = {
    language: 'ru-Ru',
    slugs: {
        contacts: {
            title: 'Контакты',
            filters: {
                status: {
                    label: 'Статус',
                    buttons: {
                        all: 'Все',
                        archive: 'Архив',
                        active: 'Активные'
                    }
                },
                search: {
                    label: 'Поиск'
                },
                create: {
                    label: 'Новый контакт'
                }
            },
            items: {
                'not-found': 'Ничего не найдено!',
                item: {
                    'no-leads': 'Нет',
                    leads: ['сделка', 'сделки', 'сделок']
                }
            }
        }
    },
    get: function(slug, found, declension) {

        var parts = slug.split('.');
        var slugs = Language.slugs;

        for (var i = 0; i < parts.length; i++) {
            slugs = slugs[parts[i]];
            if (!slugs) {
                break;
            }
        }

        if (declension) {
            if (typeof slugs == 'object') {
                return slugs;
            }
        } else {
            if (typeof slugs == 'string') {
                return slugs;
            }
        }

        return found;
    }
};

export default Language;