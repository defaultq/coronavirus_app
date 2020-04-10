import Vue from 'vue';
import App from './App.vue';
import VuePapaParse from 'vue-papa-parse';
import VModal from 'vue-js-modal'

Vue.use(VuePapaParse);
Vue.use(VModal);


Vue.config.productionTip = false;
new Vue({
  render: h => h(App),
}).$mount('#app');
