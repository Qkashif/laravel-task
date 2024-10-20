import { createRouter, createWebHistory } from 'vue-router';
import Welcome from '@/frontside/Welcome.vue';
import AdminDashboard from '@/adminside/AdminDashboard.vue';
import Login from '@/frontside/Login.vue';
import Register from '@/frontside/Register.vue';
import CategoryList from '@/adminside/categories/CategoryList.vue';
import CategoryForm from '@/adminside/categories/CategoryForm.vue';
import ProductList from '@/adminside/products/ProductList.vue';
import ProductForm from '@/adminside/products/ProductForm.vue';

import CategoryListPage from '@/frontside/CategoryListPage.vue';
import ProductDetailPage from '@/frontside/ProductDetailPage.vue';
import ProductListPage from '@/frontside/ProductListPage.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: Welcome,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
  },
  {
    path: '/admin',
    name: 'admin.dashboard',
    component: AdminDashboard,
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/categories',
    name: 'categorylist',
    component: CategoryList,
  },
  {
    path: '/admin/categories/create',
    name: 'categories.create',
    component: CategoryForm,
  },
  {
    path: '/admin/categories/:id/edit',
    name: 'categories.edit',
    component: CategoryForm,
  },
  {
    path: '/admin/products',
    name: 'ProductList',
    component: ProductList,
  },
  {
    path: '/admin/products/create',
    name: 'CreateProduct',
    component: ProductForm,
  },
  {
    path: '/admin/products/:id/edit',
    name: 'EditProduct',
    component: ProductForm,
  },


  //frontview page routes

  {
    path: '/categories',
    name: 'CategoryList',
    component: CategoryListPage,
  },
  { 
    path: '/products',
    name: 'Products',
    component: ProductListPage },
  {
    path: '/products/:id',
    name: 'ProductDetail',
    component: ProductDetailPage,
  },
  
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  // Example Auth check
  const isAuthenticated = localStorage.getItem('auth_token');
  if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
    next('/login');
  } else {
    next();
  }
});

export default router;
