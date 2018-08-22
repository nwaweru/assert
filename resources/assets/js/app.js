require('./bootstrap');

window.Vue = require('vue');

import fontawesome from '@fortawesome/fontawesome';
import solid from '@fortawesome/fontawesome-free-solid';
import regular from '@fortawesome/fontawesome-free-regular';
import brands from '@fortawesome/fontawesome-free-brands';

fontawesome.library.add(solid, regular, brands);

Vue.directive('focus', {
    inserted: function (el) {
        el.focus();
    }
});

Vue.component('asset-categories', require('./components/asset_categories/Index.vue'));

const app = new Vue({
    el: '#app'
});
