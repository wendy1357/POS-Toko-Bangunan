<script setup>
import { ref, onMounted } from "vue";
import api from "../api/axios";

const customers = ref([]);
const isLoading = ref(true);

const fetchCustomers = async () => {
  try {
    const response = await api.get("/customers");
    customers.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data pelanggan:", error);
  } finally {
    isLoading.value = false;
  }
};

onMounted(fetchCustomers);
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold mb-6">Manajemen Pelanggan</h1>
    <div v-if="isLoading">Memuat data...</div>
    <div v-else class="bg-white shadow-md rounded">
      <table class="min-w-full leading-normal">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. HP</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="customer in customers" :key="customer.id">
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
              {{ customer.nama }}
            </td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
              {{ customer.no_hp }}
            </td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
              {{ customer.alamat }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
