<script setup>
import { useRouter } from "vue-router";
import { useAuthStore } from "../store/auth";

const authStore = useAuthStore();
const router = useRouter();

const handleLogout = async () => {
  await authStore.logout();
  router.push("/");
};
</script>

<template>
  <div class="flex">
    <div class="w-64 h-screen bg-gray-800 text-white p-4 flex flex-col">
      <div>
        <h2 class="text-xl font-bold mb-4">Toko Bangunan</h2>
        <nav>
          <router-link to="/admin/dashboard" class="block py-2">Dashboard</router-link>
          <router-link to="/admin/products" class="block py-2">Produk</router-link>
          <router-link to="/admin/customers" class="block py-2">Pelanggan</router-link>
        </nav>
      </div>
      <div class="mt-auto">
        <button @click="handleLogout" class="w-full text-left py-2">Logout</button>
      </div>
    </div>

    <div class="flex-1 p-8">
      <router-view />
    </div>
  </div>
</template>
