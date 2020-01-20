import VueRouter from 'vue-router';

var Dashboard = require('./pages/Dashboard.vue').default;

var Contacts = require('./pages/contacts/Contacts.vue').default;
var Contact = require('./pages/contacts/Contact.vue').default;

var Leads = require('./pages/leads/Leads.vue').default;
var Lead = require('./pages/leads/Lead.vue').default;

var Router = new VueRouter({
    mode: 'history',
    routes: [
        {
            component: Dashboard,
            path: '/app/dashboard',
            name: 'dashboard',
            meta: {
                title: 'Дашборд'
            }
        },
        {
            component: Contacts,
            path: '/app/contacts',
            name: 'contacts',
            meta: {
                title: 'Контакты'
            },
            props: true
        },
        {
            component: Contact,
            path: '/app/contacts/:id',
            name: 'contact',
            meta: {
                title: 'Контакт'
            },
            props: true
        },
        {
            component: Leads,
            path: '/app/leads',
            name: 'leads',
            meta: {
                title: 'Сделки'
            }
        },
        {
            component: Lead,
            path: '/app/leads/:id',
            name: 'lead',
            meta: {
                title: 'Сделка'
            },
            props: true
        },
        {
            path: '*',
            redirect: '/app/dashboard'
        }
    ]
});

Router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  next();
});

export default Router;