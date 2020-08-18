import Vue from 'vue'
import App from './App.vue'
import VueResource from 'vue-resource'
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)
Vue.use(VueResource)

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
