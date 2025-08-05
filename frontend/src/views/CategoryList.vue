<script setup>
import { ref, onMounted } from "vue";
import api from "../api/axios";
import CategoryFormModal from "../components/CategoryFormModal.vue";
import { useToast } from "vue-toastification";

const toast = useToast();
const categories = ref([]);
const isLoading = ref(true);
const isModalVisible = ref(false);
const currentCategory = ref(null);

const fetchCategories = async () => {
  isLoading.value = true;
  try {
    const response = await api.get("/categories");
    categories.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data kategori:", error);
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
  currentCategory.value = null;
};

const handleSave = async (categoryData) => {
  try {
    if (categoryData.id) {
      await api.put(`/categories/${categoryData.id}`, categoryData);
      toast.success("Category berhasil diperbarui!");
    } else {
      await api.post("/categories", categoryData);
      toast.success("Category berhasil ditambah!");
    }
    closeModal();
    fetchCategories();
  } catch (error) {
    console.error("Gagal menyimpan kategori:", error);
    toast.error("Gagal menyimpan kategori");
  }
};

const deleteCategory = async (id) => {
  if (window.confirm("Apakah Anda yakin ingin menghapus kategori ini?")) {
    try {
      await api.delete(`/categories/${id}`);
      toast.success("Category berhasil dihapus.");
      fetchCategories();
    } catch (error) {
      console.error("Gagal menghapus kategori:", error);
      toast.error("Gagal mengahapus category");
    }
  }
};

onMounted(fetchCategories);
</script>

<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Manajemen Kategori</h1>
      <button @click="showAddModal" class="btn btn-primary">Tambah Kategori</button>
    </div>

    <div v-if="isLoading" class="text-center">Memuat data...</div>
    <div v-else class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="table w-full">
        <thead>
          <tr>
            <th>Nama Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories" :key="category.id" class="hover">
            <td>{{ category.name }}</td>
            <td class="space-x-2">
              <button @click="showEditModal(category)" class="btn btn-sm btn-outline btn-info">Edit</button>
              <button @delete="deleteCategory(category.id)" class="btn btn-sm btn-outline btn-error">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <CategoryFormModal :show="isModalVisible" :category="currentCategory" @close="closeModal" @save="handleSave" />
  </div>
</template>
