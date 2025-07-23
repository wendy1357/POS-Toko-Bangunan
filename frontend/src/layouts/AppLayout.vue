<template>
  <div class="flex">
    <div class="w-64 h-screen bg-gray-800 text-white p-4">
      <h2 class="text-xl font-bold mb-4">Toko Bangunan</h2>
      <nav>
        <p>Menu Navigasi di sini</p>
      </nav>
      // ...
<nav>
  <router-link to="/admin/dashboard" class="block py-2">Dashboard</router-link>
  <router-link to="/admin/products" class="block py-2">Produk</router-link>
</nav>
// ...
    </div>
    <div class="flex-1 p-8">
      <router-view />
    </div>
  </div>
</template>