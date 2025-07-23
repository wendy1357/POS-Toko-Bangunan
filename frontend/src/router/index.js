import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../store/auth"; // <-- Impor auth store
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import AppLayout from "../layouts/AppLayout.vue";
import ProductList from "../views/ProductList.vue";
import CustomerList from "../views/CustomerList.vue";

const routes = [
  {
    path: "/",
    name: "Login",
    component: Login,
  },
  {
    path: "/admin",
    component: AppLayout,
    meta: { requiresAuth: true }, // <-- Tandai grup rute ini butuh login
    children: [
      {
        path: "dashboard",
        name: "Dashboard",
        component: Dashboard,
      },
      {
        path: "products",
        name: "ProductList",
        component: ProductList,
      },
      {
        path: "customers",
        name: "CustomerList",
        component: CustomerList,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Ini adalah "Penjaga" nya
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  // Cek apakah rute yang dituju memerlukan otentikasi
  if (to.meta.requiresAuth && !authStore.token) {
    // Jika butuh login tapi tidak ada token, arahkan ke halaman login
    next({ name: "Login" });
  } else {
    // Jika tidak butuh login atau sudah ada token, lanjutkan
    next();
  }
});

export default router;
