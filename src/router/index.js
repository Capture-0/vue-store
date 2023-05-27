import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ProductIndexView from '@/views/Product/ProductIndexView.vue'
import ProductShowView from '@/views/Product/ProductShowView.vue'
import PanelLayout from '@/views/Panel/PanelLayout.vue'
import UserPanelView from '@/views/Panel/UserPanelView.vue'
import ManagePanelView from '@/views/Panel/ManagePanelView.vue'

const routes = [
  {
    path: '/',
    component: HomeView
  },
  {
    path: '/prods',
    component: ProductIndexView
  },
  {
    path: '/prods/:id',
    component: ProductShowView
  },
  {
    path: '/panel',
    component: PanelLayout,
    children: [
      {
        path: '/panel/user',
        component: UserPanelView,
        beforeEnter: (to, from, next) => {
          if (sessionStorage.token && JSON.parse(atob(sessionStorage.token.split(".")[1]))["role"] == 1)
            next();
          else next("/");
        },
      },
      {
        path: '/panel/manage',
        component: ManagePanelView,
        beforeEnter: (to, from, next) => {
          if (sessionStorage.token && JSON.parse(atob(sessionStorage.token.split(".")[1]))["role"] == 0)
            next();
          else next("/");
        },
      },
    ]
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
