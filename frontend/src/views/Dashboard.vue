<script setup>
import { ref, onMounted } from "vue";
import api from "../api/axios";

const stats = ref({
  total_sales_today: 0,
  transaction_count_today: 0,
  total_products: 0,
  total_customers: 0,
});
const isLoading = ref(true);

const fetchSummary = async () => {
  try {
    const response = await api.get("/dashboard");
    stats.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data summary:", error);
  } finally {
    isLoading.value = false;
  }
};

onMounted(fetchSummary);
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <div v-if="isLoading">Memuat statistik...</div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="stats shadow">
        <div class="stat">
          <div class="stat-title">Penjualan Hari Ini</div>
          <div class="stat-value">Rp {{ stats.total_sales_today.toLocaleString("id-ID") }}</div>
          <div class="stat-desc">Total omset hari ini</div>
        </div>
      </div>

      <div class="stats shadow">
        <div class="stat">
          <div class="stat-title">Transaksi Hari Ini</div>
          <div class="stat-value">{{ stats.transaction_count_today }}</div>
          <div class="stat-desc">Jumlah nota penjualan</div>
        </div>
      </div>

      <div class="stats shadow">
        <div class="stat">
          <div class="stat-title">Total Produk</div>
          <div class="stat-value">{{ stats.total_products }}</div>
          <div class="stat-desc">Jumlah item yang terdaftar</div>
        </div>
      </div>

      <div class="stats shadow">
        <div class="stat">
          <div class="stat-title">Total Pelanggan</div>
          <div class="stat-value">{{ stats.total_customers }}</div>
          <div class="stat-desc">Jumlah pelanggan terdaftar</div>
        </div>
      </div>
    </div>
  </div>
</template>
