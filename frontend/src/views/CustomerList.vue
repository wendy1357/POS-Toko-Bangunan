<script setup>
import { ref, onMounted } from "vue";
import api from "../api/axios";
import CustomerFormModal from "../components/CustomerFormModal.vue";

const customers = ref([]);
const isLoading = ref(true);
const isModalVisible = ref(false);
const currentCustomer = ref(null);

const fetchCustomers = async () => {
  isLoading.value = true;
  try {
    const response = await api.get("/customers");
    customers.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data pelanggan:", error);
  } finally {
    isLoading.value = false;
  }
};

const showAddModal = () => {
  currentCustomer.value = {}; // Kosongkan data untuk form tambah
  isModalVisible.value = true;
};

const showEditModal = (customer) => {
  currentCustomer.value = { ...customer }; // Isi data untuk form edit
  isModalVisible.value = true;
};

const closeModal = () => {
  isModalVisible.value = false;
  currentCustomer.value = null;
};

const handleSave = async (customerData) => {
  try {
    if (customerData.id) {
      // Mode Update
      await api.put(`/customers/${customerData.id}`, customerData);
    } else {
      // Mode Tambah
      await api.post("/customers", customerData);
    }
    closeModal();
    fetchCustomers(); // Muat ulang data
  } catch (error) {
    console.error("Gagal menyimpan pelanggan:", error);
  }
};

const deleteCustomer = async (id) => {
  if (window.confirm("Apakah Anda yakin ingin menghapus pelanggan ini?")) {
    try {
      await api.delete(`/customers/${id}`);
      fetchCustomers();
    } catch (error) {
      console.error("Gagal menghapus pelanggan:", error);
    }
  }
};

onMounted(fetchCustomers);
</script>

<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Manajemen Pelanggan</h1>
      <button @click="showAddModal" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Tambah Pelanggan</button>
    </div>

    <div v-if="isLoading">Memuat data...</div>
    <div v-else class="bg-white shadow-md rounded">
      <table class="min-w-full leading-normal">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. HP</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="customer in customers" :key="customer.id">
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ customer.nama }}</td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ customer.no_hp }}</td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ customer.alamat }}</td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
              <button @click="showEditModal(customer)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
              <button @click="deleteCustomer(customer.id)" class="text-red-600 hover:text-red-900">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <CustomerFormModal :show="isModalVisible" :customer="currentCustomer" @close="closeModal" @save="handleSave" />
  </div>
</template>
