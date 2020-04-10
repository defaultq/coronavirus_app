import Vue from 'vue';
import App from './App.vue';
import VuePapaParse from 'vue-papa-parse';
import VModal from 'vue-js-modal';
import PerfectScrollbar from 'vue2-perfect-scrollbar';
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css';


Vue.use(VuePapaParse);
Vue.use(VModal);
Vue.use(PerfectScrollbar);

Vue.config.productionTip = false;
new Vue({
  render: h => h(App),
}).$mount('#app');
