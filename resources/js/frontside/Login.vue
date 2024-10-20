<template>
    <div class="min-h-screen flex justify-center items-center bg-gray-50">
      <div class="w-full max-w-md p-8 bg-white rounded shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Admin Login</h2>
        <form @submit.prevent="login">
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input 
              v-model="email"
              type="email"
              id="email"
              class="mt-1 block w-full p-2 border border-gray-300 rounded" 
              required 
            />
          </div>
          <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input 
              v-model="password" 
              type="password" 
              id="password" 
              class="mt-1 block w-full p-2 border border-gray-300 rounded" 
              required 
            />
          </div>
          <button 
            type="submit" 
            class="w-full bg-indigo-500 text-white font-semibold py-2 rounded hover:bg-indigo-600 transition duration-300"
          >
            Login
          </button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
      };
    },
    methods: {
      async login() {
        try {
          const response = await axios.post('/api/login', {
            email: this.email,
            password: this.password,
          });
          localStorage.setItem('auth_token', response.data.token);        

          if (response.data.is_admin) {
            this.$router.push('/admin');
          }
          else{
            this.$router.push('/');
          }
        } catch (error) {
          alert('Invalid credentials');
        }
      },
    },
  };
  </script>
  