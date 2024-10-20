<template>
  <div class="min-h-screen bg-gray-50 flex flex-col">
    <header class="bg-white shadow-md">
      <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
        <div class="text-2xl font-bold text-gray-800">
          <router-link to="/" class="hover:text-indigo-500 transition duration-300">Home</router-link>
        </div>
        <div class="flex space-x-6 text-gray-700">
          <router-link to="/categories" class="hover:text-indigo-500 transition duration-300">
            Categories
          </router-link>
          <router-link to="/products" class="hover:text-indigo-500 transition duration-300">
            Products
          </router-link>
          <router-link v-if="!isAuthenticated" to="/login" class="hover:text-indigo-500 transition duration-300">
            Login
          </router-link>
          <router-link v-if="!isAuthenticated" to="/register" class="hover:text-indigo-500 transition duration-300">
            Register
          </router-link>
          <router-link v-if="isAdmin" to="/admin" class="hover:text-indigo-500 transition duration-300">
            Dashboard
          </router-link>
          <button 
            v-if="isAuthenticated" 
            @click="logout" 
            class="hover:text-indigo-500 transition duration-300"
          >
            Logout
          </button>
        </div>
      </nav>
    </header>
    <main class="flex-grow container mx-auto px-6 py-16 text-center">
      <h1 class="text-4xl font-extrabold text-gray-800 mb-4">
        Welcome {{ userName || 'Dear' }} to Our Website!
      </h1>
      <p class="text-lg text-gray-600 mb-8">
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Debitis, veritatis!
      </p>
      <router-link 
        v-if="!isAuthenticated" 
        to="/categories" 
        class="inline-block bg-indigo-500 text-white font-semibold px-6 py-3 rounded-lg shadow hover:bg-indigo-600 transition duration-300"
      >
        Explore Categories
      </router-link>
    </main>
    <footer class="bg-gray-800 text-gray-200 py-4 text-center">
      <p class="text-sm">
        &copy; kashif-lateef.
      </p>
    </footer>
  </div>
</template>
<script>
import axios from 'axios';

export default {
  data() {
    return {
      isAuthenticated: false,
      isAdmin: false,
      userName: '',
    };
  },
  methods: {
    async checkAuth() {
      const token = localStorage.getItem('auth_token');
      if (!token) {
        this.isAuthenticated = false;
        this.isAdmin = false;
        this.userName = ''; 
        return;
      }  
      try {
        const response = await axios.get('/api/user', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        this.isAuthenticated = true;
        this.isAdmin = response.data.is_admin;
        this.userName = response.data.name;
      } catch (error) {
        console.error('Error fetching user details:', error);
        this.isAuthenticated = false;
        this.isAdmin = false;
        this.userName = '';
      }
    },
    logout() {
      localStorage.removeItem('auth_token');
      this.isAuthenticated = false;
      this.isAdmin = false;
      this.userName = '';
      this.$router.push('/');
    },
  },
  mounted() {
    this.checkAuth();
  },
};
</script>
