<template>
    <div id="contact">
        <transition name="fade" mode="out-in">
            <div v-if="!loading" key="contact" class="content">
                <div class="sidebar">
                    <div class="head">
                        <div class="head-title">{{fields.firstname.value}} {{fields.lastname.value}}</div>
                    </div>
                    <div class="fields">
                        <field-text v-for="(field, index) in fields"
                            :clear="true"
                            :key="index"
                            :field="field">
                        </field-text>
                        <transition name="fade">
                            <div v-if="isChanged" class="fields-save">
                                <div class="fields-save-description">
                                    Сохранить изменения?
                                </div>
                                <div class="fields-save-buttons">
                                    <div class="fields-save-buttons-item save">
                                        <div @click="save()" class="button black">
                                            <button>
                                                <!-- <i class="glyphicon glyphicon-ok"></i> --> Сохранить
                                            </button>
                                        </div>
                                    </div>
                                    <div class="fields-save-buttons-item cancel">
                                        <div @click="reset()" class="button transparent">
                                            <button>
                                                <!-- <i class="glyphicon glyphicon-remove"></i> --> Отменить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>
                    <div class="footer"></div>
                </div>
                <div class="timeline">
                    <div class="timeline-item"></div>
                </div>
            </div>
            <div v-else key="loading" class="content">
                <div class="sidebar sidebar-loading">
                    <i class="glyphicon glyphicon-refresh glyphicon-spin"></i> Загрузка
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import Text from './../../components/fields/Text';

    export default {
        props: ['id'],
        components: {
            'field-text': Text
        },
        data: function() {
            return {
                isChanged: false,
                fields: {},
                current: {},
                loading: true,
            }
        },
        watch: {
            fields: {
                handler: function() {
                    this.isChanged = !Functions.compare(this.fields, this.current);
                    this.local();
                },
                deep: true
            },
        },
        methods: {
            save: function() {
                var self = this,
                    fields = {};

                for (var field in self.fields) {
                    fields[field] = self.fields[field].value;
                }

                Functions.request.put('/app/contacts/' + self.id, fields, function(responce) {
                    if (responce) {
                        self.current = Functions.copy(self.fields);
                        self.isChanged = false;
                        self.local();

                        if (responce != self.id) {
                            self.$router.replace({name: 'contact', params: {id: responce}});
                        }
                    }
                });
            },
            local: function() {
                if (this.isChanged) {
                    Functions.local.set('contact-' + this.id, this.fields);
                } else {
                    Functions.local.clear('contact-' + this.id);
                }
            },
            reset: function() {
                this.fields = Functions.copy(this.current);
            }
        },
        mounted: function() {
            
        },
        created: function() {
            var self = this;

            Functions.request.get('/app/contacts/' + self.id, null, function(responce) {
                if (responce) {

                    self.fields = Functions.copy(responce);
                    self.current = Functions.copy(responce);
                    self.loading = false;

                    document.title = 'Контакт - ' + self.fields.firstname.value + ' ' + self.fields.lastname.value;

                    var local = Functions.local.get('contact-' + self.id);
                    if (local) {
                        self.fields = local;
                    }
                }
            });
        }
    };
</script>