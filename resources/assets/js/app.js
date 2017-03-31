// requires
var Vue = require('vue');
var VueMaterial = require('vue-material');
var VueResource = require('vue-resource-2');


// vue resource setup
Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
Vue.http.options.emulateJSON = true;
Vue.http.options.emulateHTTP = true;


// vue material setup
Vue.use(VueMaterial);

Vue.material.registerTheme('default', {
    primary: 'teal',
    accent: 'red',
    warn: 'red',
});

Vue.material.registerTheme('inverted', {
    primary: 'red',
    accent: 'red',
});


// components
import AuthCard from './components/AuthCard';
import QuickAction from './components/QuickAction';
import SecureCloud from './components/SecureCloud';
import FileSearch from './components/FileSearch';

import Ajax from './support/Ajax';

// vue root instance
new Vue({
    el: 'main',
    methods: {
        deleteShareByHash: function(hash) {

            // fetch new files
            this.$http.post('/share/delete/' + hash).then(function(response) {
                Ajax.showAlert(response);
                $('[data-fileshare-hash="' + hash + '"]').slideUp("slow");
            }, response => {
                Ajax.handleServerError(response);
            });

        }
    },
    components:{
        'auth-card': AuthCard,
        'quick-action': QuickAction,
        'secure-cloud': SecureCloud,
        'file-search': FileSearch
    }
});