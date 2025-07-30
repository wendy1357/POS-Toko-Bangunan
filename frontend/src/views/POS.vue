<script setup>
import { ref, onMounted, computed } from "vue";
import api from "../api/axios";

const products = ref([]);
const isLoading = ref(true);
const cart = ref([]);

// Mengambil semua data produk dari backend
const fetchProducts = async () => {
  try {
    // Memastikan kita juga mengambil data 'units' yang berisi harga jual
    const response = await api.get("/products");
    products.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data produk:", error);
  } finally {
    isLoading.value = false;
  }
};

// Fungsi untuk menambah produk ke keranjang
const addToCart = (product) => {
  // Cek apakah produk sudah ada di keranjang
  const itemInCart = cart.value.find((item) => item.id === product.id);

  if (itemInCart) {
    // Jika ada, tambah jumlahnya
    itemInCart.quantity++;
  } else {
    // Jika belum ada, tambahkan ke keranjang
    // Kita asumsikan menggunakan harga dari 'unit' pertama
    if (product.units && product.units.length > 0) {
      cart.value.push({
        id: product.id,
        nama_produk: product.nama_produk,
        quantity: 1,
        product_unit_id: product.units[0].id, // Ambil id dari unit pertama
        harga_jual: product.units[0].harga_jual,
      });
    } else {
      alert("Produk ini tidak memiliki satuan jual yang valid.");
    }
  }
};

// Menghitung total belanja secara otomatis setiap kali 'cart' berubah
const cartTotal = computed(() => {
  return cart.value.reduce((total, item) => {
    return total + item.quantity * item.harga_jual;
  }, 0);
});

// Fungsi untuk menyelesaikan transaksi
const submitSale = async () => {
  if (cart.value.length === 0) {
    alert("Keranjang masih kosong!");
    return;
  }

  // Format data sesuai yang dibutuhkan backend
  const saleData = {
    amount_paid: cartTotal.value, // Asumsi bayar pas
    cart: cart.value.map((item) => ({
      product_unit_id: item.product_unit_id,
      quantity: item.quantity,
    })),
  };

  try {
    await api.post("/sales", saleData);
    alert("Transaksi berhasil disimpan!");
    cart.value = []; // Kosongkan keranjang
  } catch (error) {
    console.error("Gagal menyimpan transaksi:", error.response.data);
    alert("Gagal menyimpan transaksi: " + error.response.data.message);
  }
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

    <div class="w-2/5 p-4 bg-white border-l flex flex-col">
      <h2 class="text-xl font-bold mb-4">Keranjang</h2>
      <div class="flex-1 overflow-y-auto">
        <div v-if="cart.length === 0" class="text-center text-gray-500 pt-10">Keranjang masih kosong</div>
        <div v-else>
          <div v-for="item in cart" :key="item.id" class="flex justify-between items-center mb-2">
            <div>
              <p class="font-semibold">{{ item.nama_produk }}</p>
              <p class="text-sm text-gray-600">Rp {{ item.harga_jual }} x {{ item.quantity }}</p>
            </div>
            <p class="font-semibold">Rp {{ item.quantity * item.harga_jual }}</p>
          </div>
        </div>
      </div>
      <div class="border-t pt-4">
        <div class="flex justify-between font-bold text-lg">
          <span>Total</span>
          <span>Rp {{ cartTotal }}</span>
        </div>
        <button @click="submitSale" class="w-full mt-4 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Selesaikan Transaksi</button>
      </div>
    </div>
  </div>
</template>
