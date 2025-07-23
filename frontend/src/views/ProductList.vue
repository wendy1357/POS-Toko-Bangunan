<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

// Variabel untuk menampung data produk
const products = ref([]);
// Variabel untuk status loading
const isLoading = ref(true);

// Fungsi untuk mengambil data dari API
const fetchProducts = async () => {
  try {
    const response = await axios.get("http://127.0.0.1:8000/api/products");
    products.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data produk:", error);
  } finally {
    isLoading.value = false;
  }
};

// Jalankan fungsi fetchProducts saat komponen pertama kali dimuat
onMounted(() => {
  fetchProducts();
});
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold mb-6">Manajemen Produk</h1>

    <div v-if="isLoading">
      <p>Memuat data...</p>
    </div>

    <div v-else class="bg-white shadow-md rounded">
      <table class="min-w-full leading-normal">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Produk</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stok</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id">
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
              <p class="text-gray-900 whitespace-no-wrap">{{ product.nama_produk }}</p>
            </td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
              <p class="text-gray-900 whitespace-no-wrap">{{ product.stock_in_base_unit }} {{ product.base_unit }}</p>
            </td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
              <p class="text-gray-900 whitespace-no-wrap">{{ product.category.name }}</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
