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
          <nav class="flex flex-col space-y-2">
            <router-link to="/admin/pos" class="px-4 py-2 rounded hover:bg-gray-700">Kasir</router-link>
            <router-link to="/admin/dashboard" class="px-4 py-2 rounded hover:bg-gray-700">Dashboard</router-link>
            <router-link to="/admin/products" class="px-4 py-2 rounded hover:bg-gray-700">Produk</router-link>
            <router-link to="/admin/customers" class="px-4 py-2 rounded hover:bg-gray-700">Pelanggan</router-link>
            <router-link to="/admin/categories" class="px-4 py-2 rounded hover:bg-gray-700">Kategori</router-link>
          </nav>
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
