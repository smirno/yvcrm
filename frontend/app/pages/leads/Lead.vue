<template>
    <div id="lead">
        <transition name="fade" mode="out-in">
            <div v-if="!loading" key="lead" class="content">
                <div class="sidebar">
                    <div class="head">
                        <div class="head-title">{{lead.name}}</div>
                    </div>
                    <div class="fields">
                        <field-text v-for="(field, index) in fields"
                            :key="index"
                            :field="field">
                        </field-text>
                        <transition name="fade">
                            <div v-if="isChanged" class="content-buttons">
                                <div @click="save()" class="button green">
                                    <button><i class="glyphicon glyphicon-ok"></i> Сохранить</button>
                                </div>
                                <div @click="reset()" class="button">
                                    <button><i class="glyphicon glyphicon-remove"></i> Отменить изменения</button>
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

                Functions.request.put('/app/leads/' + self.id, fields, function(responce) {
                    if (responce) {
                        self.current = Functions.copy(self.fields);
                        self.isChanged = false;
                        self.local();

                        if (responce != self.id) {
                            self.$router.replace({name: 'lead', params: {id: responce}});
                        }
                    }
                });
            },
            local: function() {
                if (this.isChanged) {
                    Functions.local.set('lead-' + this.id, this.fields);
                } else {
                    Functions.local.clear('lead-' + this.id);
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

            Functions.request.get('/app/leads/' + self.id, null, function(responce) {
                if (responce) {

                    if (responce.lead) {
                        self.lead = Functions.copy(responce.lead);
                    }

                    if (responce.fields) {
                        self.fields = Functions.copy(responce.fields);
                        self.current = Functions.copy(responce.fields);
                        self.loading = false;
                    }

                    var local = Functions.local.get('lead-' + self.id);
                    if (local) {
                        self.fields = local;
                    }

                }
            });
        }
    };
</script>