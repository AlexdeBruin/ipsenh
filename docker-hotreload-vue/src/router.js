import Vue from 'vue'
import Router from 'vue-router'
import store from './store'

import Login from './components/Login.vue'
import Dashboard from './components/Dashboard.vue'
import Register from './components/Register.vue'
import RegisterCourse from './components/Courses/RegisterCourse.vue'
import StructureGrades from './components/Grades/StructureGrades'
import CourseInfo from "./components/Courses/CourseInfo";
import Courses from "./components/Courses/Courses";
import CoursesHolder from "./components/Courses/CoursesHolder";
import Announcement from "./components/Courses/Announcement/Announcement";
import CourseDashboard from './components/Teacher/CourseDashboard.vue'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'Login',
      component: Login
    },
    {
      path: '/Login',
      name: 'redictLogin',
      redirect: '/'
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard,
    },
    {
      path: '/register/:choice',
      name: 'register',
      component: Register,
      props: true
    },
    {
      path: '/courses',
      component: CoursesHolder,
      children: [
        {
          path: '',
          name: 'courses',
          component: Courses
        },
        {
          name: 'courseRegister',
          path: 'registerCourse',
          component: RegisterCourse
        },
        {
          name: 'courseInfo',
          path: ':id',
          component: CourseInfo
        },
        {
          name: 'announcement',
          path: '/announcement/:id',
          component: Announcement
        },
        {
          path: ':id/dashboard',
          name: 'courseDashboard',
          component: CourseDashboard
        }
      ]
    },
    {
      path: '/grades',
      name: 'Grades',
      component: StructureGrades
    },

  ]
})

router.beforeEach((to, from, next) => {
  if (store.getters['auth/loggedin']) {

    if (['Login', 'redictLogin'].indexOf(to.name) === -1) {
      next();
    } else {
      next({ name: 'dashboard' })
    }

  } else {
    if (['Login', 'redictLogin'].indexOf(to.name) === -1) {
      next('/')
    } else {
      next();
    }
  }
});

export default router