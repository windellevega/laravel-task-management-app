import Vue from 'vue'
import VueRouter from 'vue-router'
import VueMeta from 'vue-meta'
import { sync } from 'vuex-router-sync'

import 'core-js/stable'
import App from './App'
import routerList from './router'
import CoreuiVue from '@coreui/vue'
import { iconsSet as icons } from './assets/icons/icons.js'
import store from './store'
import './axios'

Vue.config.performance = true

Vue.use(CoreuiVue)
Vue.use(VueRouter)
Vue.use(VueMeta)
Vue.prototype.$log = console.log.bind(console)

/**
 * Create vue router instance
 */
 const router = new VueRouter(routerList)

 router.beforeEach((to, from, next) => {
   if (to.meta.requiresAuth && !store.state.auth.isLoggedIn) {
     console.log('You must be logged in')
     next({ path: '/login' })
   } 
   else {
    console.log('You are logged in')
     next()
   }
 })
 
 /**
  * Sync router to store
  */
 sync(store, router)

new Vue({
  el: '#app',
  router,
  store,
  icons,
  template: '<App/>',
  components: {
    App
  }
})
