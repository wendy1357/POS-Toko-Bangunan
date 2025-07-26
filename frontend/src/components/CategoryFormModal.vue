<script setup>
import { ref, watch } from "vue";

// Props untuk menerima data dari parent
const props = defineProps({
  show: Boolean,
  category: Object,
});

// Emits untuk mengirim event ke parent
const emit = defineEmits(["close", "save"]);

const form = ref({});

// Watcher untuk mengisi form saat data customer berubah (untuk mode edit)
watch(
  () => props.category,
  (newVal) => {
    form.value = { ...newVal };
  }
);

const save = () => {
  emit("save", form.value);
};

const close = () => {
  emit("close");
};
</script>

<template>
  <div v-if="show" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
    <div class="relative mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
      <div class="mt-3 text-center">
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ category?.id ? "Edit" : "Tambah" }} Category</h3>
        <div class="mt-2 px-7 py-3">
          <form @submit.prevent="save" class="space-y-4 text-left">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
              <input v-model="form.name" type="text" id="name" required class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md" />
            </div>
            <div class="items-center px-4 py-3">
              <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-indigo-700">Simpan</button>
              <button type="button" @click="close" class="mt-2 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
