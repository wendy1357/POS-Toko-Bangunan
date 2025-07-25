import { defineStore } from "pinia";
import { ref } from "vue";
import api from "../api/axios";

export const useAuthStore = defineStore("auth", () => {
  // State: Menyimpan data user dan token
  const user = ref(JSON.parse(localStorage.getItem("user")));
  const token = ref(localStorage.getItem("token"));

  // Actions: Fungsi untuk mengubah state
  function login(userData, authToken) {
    user.value = userData;
    token.value = authToken;
    // Simpan ke localStorage agar tidak hilang saat refresh
    localStorage.setItem("user", JSON.stringify(userData));
    localStorage.setItem("token", authToken);
  }

  async function logout() {
    try {
      // Panggil API logout di backend
      await api.post("/logout");
    } catch (error) {
      console.error("Gagal logout di server:", error);
    } finally {
      // Selalu bersihkan state di frontend
      user.value = null;
      token.value = null;
      localStorage.removeItem("user");
      localStorage.removeItem("token");
    }
  }

  return { user, token, login, logout };
});
