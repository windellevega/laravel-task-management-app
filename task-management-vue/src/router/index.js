// Containers
const TheContainer = () => import('@/containers/TheContainer')

//Components
const AssignedTasks = () => import('@/components/Task/AssignedTasks')
const MyTasks = () => import('@/components/Task/MyTasks')

const Login = () => import('@/components/Login')
const Register = () => import('@/components/Register')

export default {
  mode: 'history',
  base: '/',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: TheContainer,
      children: [
        {
          path: 'assigned-tasks',
          name: 'Assigned Tasks',
          component: AssignedTasks,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'my-tasks',
          name: 'My Tasks',
          component: MyTasks,
          meta: {
            requiresAuth: true
          }
        },
      ],
      meta: {
        requiresAuth: true
      }
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

