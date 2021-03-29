import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('@/views/Home.vue'),
      meta: {
        pageTitle: 'Home',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Home',
            active: true,
          },
        ],
      },
    },
    {
      path: '/category',
      name: 'category',
      component: () => import('@/views/categories/CategoryList.vue'),
      meta: {
        pageTitle: 'Category',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Category List',
            active: true,
          },
        ],
      },
    },
    {
      path: '/category-add',
      name: 'category-add',
      component: () => import('@/views/categories/CategoryAdd.vue'),
      meta: {
        pageTitle: 'Category Add',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Category Add',
            active: true,
          },
        ],
      },
    },
    {
      path: '/category-edit/:id',
      name: 'category-edit',
      component: () => import('@/views/categories/CategoryEdit.vue'),
      meta: {
        pageTitle: 'Category Edit',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Category Edit',
            active: true,
          },
        ],
      },
    },


    {
      path: '/brand',
      name: 'brand',
      component: () => import('@/views/brand/BrandList.vue'),
      meta: {
        pageTitle: 'Brand',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Brand List',
            active: true,
          },
        ],
      },
    },
    {
      path: '/brand-add',
      name: 'brand-add',
      component: () => import('@/views/brand/BrandAdd.vue'),
      meta: {
        pageTitle: 'Brand Add',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Brand Add',
            active: true,
          },
        ],
      },
    },
    {
      path: '/brand-edit/:id',
      name: 'brand-edit',
      component: () => import('@/views/brand/BrandEdit.vue'),
      meta: {
        pageTitle: 'Brand Edit',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Brand Edit',
            active: true,
          },
        ],
      },
    },

    {
      path: '/variations',
      name: 'variation',
      component: () => import('@/views/variations/VariationList.vue'),
      meta: {
        pageTitle: 'Variation',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Variation List',
            active: true,
          },
        ],
      },
    },

    {
      path: '/unit',
      name: 'unit',
      component: () => import('@/views/unit/UnitList.vue'),
      meta: {
        pageTitle: 'Unit',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Unit List',
            active: true,
          },
        ],
      },
    },
    {
      path: '/unit-add',
      name: 'unit-add',
      component: () => import('@/views/unit/UnitAdd.vue'),
      meta: {
        pageTitle: 'Unit Add',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Unit Add',
            active: true,
          },
        ],
      },
    },
    {
      path: '/unit-edit/:id',
      name: 'unit-edit',
      component: () => import('@/views/unit/UnitEdit.vue'),
      meta: {
        pageTitle: 'Unit Edit',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Unit Edit',
            active: true,
          },
        ],
      },
    },
{
      path: '/country',
      name: 'country',
      component: () => import('@/views/country/CountryList.vue'),
      meta: {
        pageTitle: 'Country',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Country List',
            active: true,
          },
        ],
      },
    },
    {
      path: '/country-add',
      name: 'country-add',
      component: () => import('@/views/country/CountryAdd.vue'),
      meta: {
        pageTitle: 'Country Add',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Country Add',
            active: true,
          },
        ],
      },
    },
    {
      path: '/country-edit/:id',
      name: 'country-edit',
      component: () => import('@/views/country/CountryEdit.vue'),
      meta: {
        pageTitle: 'Country Edit',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Country Edit',
            active: true,
          },
        ],
      },
    },




    {
      path: '/currency',
      name: 'currency',
      component: () => import('@/views/currency/CurrencyList.vue'),
      meta: {
        pageTitle: 'Currency',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Currency List',
            active: true,
          },
        ],
      },
    },
    {
      path: '/currency-add',
      name: 'currency-add',
      component: () => import('@/views/currency/CurrencyAdd.vue'),
      meta: {
        pageTitle: 'Currency Add',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Currency Add',
            active: true,
          },
        ],
      },
    },
    {
      path: '/currency-edit/:id',
      name: 'currency-edit',
      component: () => import('@/views/currency/CurrencyEdit.vue'),
      meta: {
        pageTitle: 'Currency Edit',
        authOnly: true,
        breadcrumb: [
          {
            text: 'Currency Edit',
            active: true,
          },
        ],
      },
    },








    {
      path: '/register',
      name: 'register',
      component: () => import('@/views/Registration.vue'),
      meta: {
        layout: 'full',
        guestOnly: true
      },
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/Login.vue'),
      meta: {
        layout: 'full',
        guestOnly: true
      },
    },
    
    {
      path: '/error-404',
      name: 'error-404',
      component: () => import('@/views/error/Error404.vue'),
      meta: {
        layout: 'full',
        authOnly: true,
      },
    },
    {
      path: '*',
      redirect: 'error-404',
    },
  ],
})

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})









function isLoggedIn() {
  return localStorage.getItem("token");
}

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.authOnly)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!isLoggedIn()) {
      next({
        path: "/login",
        query: { redirect: to.fullPath }
      });
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.guestOnly)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (isLoggedIn()) {
      next({
        path: "/",
        // query: { redirect: to.fullPath }
      });
    } else {
      next();
    }
  } else {
    next(); // make sure to always call next()!
  }
});














export default router
