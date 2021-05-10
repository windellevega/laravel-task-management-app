import Vue from 'vue'
import Router from 'vue-router'

// Containers
const TheContainer = () => import('@/containers/TheContainer')

//Components
const AssignedTasks = () => import('@/components/Task/AssignedTasks')
const MyTasks = () => import('@/components/Task/MyTasks')

const Login = () => import('@/components/Login')
const Register = () => import('@/components/Register')

Vue.use(Router)

export default new Router({
  mode: 'hash', // https://router.vuejs.org/api/#mode
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes: configRoutes()
})

function configRoutes () {
  return [
    {
      path: '/',
      name: 'Home',
      component: TheContainer,
      children: [
        {
          path: 'assigned-tasks',
          name: 'Assined Tasks',
          component: AssignedTasks
        },
        {
          path: 'my-tasks',
          name: 'My Tasks',
          component: MyTasks
        },
      ]
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    }
  ]
}

