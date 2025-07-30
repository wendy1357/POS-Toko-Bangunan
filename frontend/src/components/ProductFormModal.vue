<script setup>
import { ref, watch, onMounted } from "vue";
import api from "../api/axios";

const props = defineProps({
  show: Boolean,
  product: Object,
});

const emit = defineEmits(["close", "save"]);

const form = ref({});
const categories = ref([]);

// Ambil daftar kategori saat komponen dimuat
onMounted(async () => {
  try {
    const response = await api.get("/categories");
    categories.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data kategori:", error);
  }
});

// Isi form saat mode edit
watch(
  () => props.product,
  (newVal) => {
    form.value = { ...newVal };
  }
);

const save = () => emit("save", form.value);
const close = () => emit("close");
</script>

<template>
  <div v-if="show" class="modal modal-open">
    <div class="modal-box">
      <h3 class="font-bold text-lg">{{ product?.id ? "Edit" : "Tambah" }} Produk</h3>
      <form @submit.prevent="save" class="space-y-4 py-4">
        <div>
          <label class="label"><span class="label-text">Nama Produk</span></label>
          <input v-model="form.nama_produk" type="text" required class="input input-bordered w-full" />
        </div>
        <div>
          <label class="label"><span class="label-text">Kategori</span></label>
          <select v-model="form.category_id" class="select select-bordered w-full">
            <option disabled selected>Pilih Kategori</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
          </select>
        </div>
        <div>
          <label class="label"><span class="label-text">Stok Awal</span></label>
          <input v-model="form.stock_in_base_unit" type="number" required class="input input-bordered w-full" />
        </div>
        <div>
          <label class="label"><span class="label-text">Satuan Dasar</span></label>
          <input v-model="form.base_unit" type="text" required placeholder="Contoh: Pcs, Kg, Sak" class="input input-bordered w-full" />
        </div>
        <div>
          <label class="label"><span class="label-text">Harga Beli</span></label>
          <input v-model="form.harga_beli_per_base_unit" type="number" required class="input input-bordered w-full" />
        </div>
      </form>
      <div class="modal-action">
        <button @click="save" class="btn btn-primary">Simpan</button>
        <button @click="close" class="btn">Batal</button>
      </div>
    </div>
  </div>
</template>
