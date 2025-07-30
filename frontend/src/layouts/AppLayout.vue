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
  <div class="flex h-screen bg-gray-100">
    <div class="w-64 bg-gray-800 text-white flex-shrink-0">
      <div class="p-4 text-xl font-bold">Toko Bangunan</div>
      <ul class="menu p-2">
        <li><router-link to="/admin/pos">Kasir</router-link></li>
        <li><router-link to="/admin/dashboard">Dashboard</router-link></li>
        <li class="menu-title"><span>Master Data</span></li>
        <li><router-link to="/admin/products">Produk</router-link></li>
        <li><router-link to="/admin/customers">Pelanggan</router-link></li>
        <li><router-link to="/admin/categories">Kategori</router-link></li>
      </ul>
      <div class="p-2 mt-auto">
        <button @click="handleLogout" class="btn btn-ghost w-full justify-start">Logout</button>
      </div>
    </div>

    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="bg-white shadow p-4">
        <div class="font-bold">Selamat Datang!</div>
      </header>

      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
        <router-view />
      </main>
    </div>
  </div>
</template>
