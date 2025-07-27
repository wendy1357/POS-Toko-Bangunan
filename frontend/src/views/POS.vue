<script setup>
import { ref, onMounted } from "vue";
import api from "../api/axios";

const products = ref([]);
const isLoading = ref(true);

// Mengambil semua data produk dari backend
const fetchProducts = async () => {
  try {
    const response = await api.get("/products");
    products.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data produk:", error);
  } finally {
    isLoading.value = false;
  }
};

// Fungsi ini akan kita kembangkan nanti
const addToCart = (product) => {
  console.log("Menambahkan produk:", product.nama_produk);
};

onMounted(fetchProducts);
</script>

<template>
  <div class="flex h-[calc(100vh-4rem)]">
    <div class="w-3/5 p-4 overflow-y-auto">
      <h2 class="text-xl font-bold mb-4">Daftar Produk</h2>
      <div v-if="isLoading">Memuat produk...</div>
      <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div v-for="product in products" :key="product.id" @click="addToCart(product)" class="border rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100">
          <p class="font-semibold">{{ product.nama_produk }}</p>
          <p class="text-sm text-gray-500">Stok: {{ product.stock_in_base_unit }}</p>
        </div>
      </div>
    </div>

    <div class="w-2/5 p-4 bg-white border-l">
      <h2 class="text-xl font-bold mb-4">Keranjang</h2>
      <div class="text-center text-gray-500">Keranjang masih kosong</div>
    </div>
  </div>
</template>
