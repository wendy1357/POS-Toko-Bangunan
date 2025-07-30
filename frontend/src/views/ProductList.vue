<script setup>
import { ref, onMounted } from "vue";
import api from "../api/axios";
import ProductFormModal from "../components/ProductFormModal.vue";

const products = ref([]);
const isLoading = ref(true);
const isModalVisible = ref(false);
const currentProduct = ref(null);

const fetchProducts = async () => {
  isLoading.value = true;
  try {
    const response = await api.get("/products");
    products.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data produk:", error);
  } finally {
    isLoading.value = false;
  }
};

const showAddModal = () => {
  currentProduct.value = {};
  isModalVisible.value = true;
};

const showEditModal = (product) => {
  currentProduct.value = { ...product };
  isModalVisible.value = true;
};

const closeModal = () => {
  isModalVisible.value = false;
  currentProduct.value = null;
};

const handleSave = async (productData) => {
  try {
    if (productData.id) {
      await api.put(`/products/${productData.id}`, productData);
    } else {
      await api.post("/products", productData);
    }
    closeModal();
    fetchProducts();
  } catch (error) {
    console.error("Gagal menyimpan produk:", error);
  }
};

const deleteProduct = async (id) => {
  if (window.confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
    try {
      await api.delete(`/products/${id}`);
      fetchProducts();
    } catch (error) {
      console.error("Gagal menghapus produk:", error);
    }
  }
};

onMounted(fetchProducts);
</script>

<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Manajemen Produk</h1>
      <button @click="showAddModal" class="btn btn-primary">Tambah Produk</button>
    </div>

    <div v-if="isLoading" class="text-center">Memuat data...</div>
    <div v-else class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="table w-full">
        <thead>
          <tr>
            <th>Nama Produk</th>
            <th>Stok</th>
            <th>Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id" class="hover">
            <td>{{ product.nama_produk }}</td>
            <td>{{ product.stock_in_base_unit }} {{ product.base_unit }}</td>
            <td>{{ product.category.name }}</td>
            <td class="space-x-2">
              <button @click="showEditModal(product)" class="btn btn-sm btn-outline btn-info">Edit</button>
              <button @click="deleteProduct(product.id)" class="btn btn-sm btn-outline btn-error">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <ProductFormModal :show="isModalVisible" :product="currentProduct" @close="closeModal" @save="handleSave" />
  </div>
</template>
