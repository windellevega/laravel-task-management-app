import Vue from 'vue'
import Router from 'vue-router'

// Containers
const TheContainer = () => import('@/containers/TheContainer')

//Components
const AssignedTasks = () => import('@/components/AssignedTasks')
const MyTasks = () => import('@/components/MyTasks')

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
      path: '',
      redirect: '',
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
    }
  ]
}

