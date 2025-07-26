<script setup>
import { ref, onMounted } from "vue";
import api from "../api/axios";
import CategoryFormModal from "../components/CategoryFormModal.vue";

const categories = ref([]);
const isLoading = ref(true);
const isModalVisible = ref(false);
const currentCategory = ref(null);

const fetchCategory = async () => {
  // <-- Perbaiki nama fungsi
  try {
    const response = await api.get("/categories"); // GANTI ENDPOINT
    categories.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data Category:", error);
  } finally {
    isLoading.value = false;
  }
};

const showAddModal = () => {
  currentCategory.value = {};
  isModalVisible.value = true;
};

const showEditModal = (category) => {
  currentCategory.value = { ...category };
  isModalVisible.value = true;
};

const closeModal = () => {
  isModalVisible.value = false;
  currentCategory.value = null; // PERBAIKI TYPO
};

const handleSave = async (categoryData) => {
  try {
    if (categoryData.id) {
      // Mode Update
      await api.put(`/categories/${categoryData.id}`, categoryData); // GANTI ENDPOINT
    } else {
      // Mode Tambah
      await api.post("/categories", categoryData); // GANTI ENDPOINT
    }
    closeModal();
    fetchCategory();
  } catch (error) {
    console.error("Gagal menyimpan category:", error);
  }
};

const deleteCategory = async (id) => {
  console.log("ID yang akan dihapus:", id); // <-- Tambahkan ini untuk debugging
  if (window.confirm("Apakah Anda yakin ingin menghapus category ini?")) {
    try {
      await api.delete(`/categories/${id}`); // GANTI ENDPOINT
      fetchCategory();
    } catch (error) {
      console.error("Gagal menghapus category:", error);
    }
  }
};

onMounted(fetchCategory);
</script>

<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Manajemen Category</h1>
      <button @click="showAddModal" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Tambah Category</button>
    </div>

    <div v-if="isLoading">Memuat data...</div>
    <div v-else class="bg-white shadow-md rounded">
      <table class="min-w-full leading-normal">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories" :key="category.id">
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ category.name }}</td>
            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
              <button @click="showEditModal(category)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
              <button @click="deleteCategory(category.id)" class="text-red-600 hover:text-red-900">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <CategoryFormModal :show="isModalVisible" :category="currentCategory" @close="closeModal" @save="handleSave" />
  </div>
</template>
