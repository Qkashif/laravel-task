<template>
    <div class="min-h-screen flex justify-center items-center bg-gray-50">
      <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Register</h2>
        <form @submit.prevent="registerUser">
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input
              v-model="form.name"
              type="text"
              id="name"
              class="mt-1 block w-full p-2 border border-gray-300 rounded"
              required
            />
          </div>
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              v-model="form.email"
              type="email"
              id="email"
              class="mt-1 block w-full p-2 border border-gray-300 rounded"
              required
            />
          </div>
          <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
              v-model="form.password"
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
            Register
          </button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";

  export default {
    data() {
      return {
        form: {
          name: "",
          email: "",
          password: "",
        },
      };
    },
    methods: {
      registerUser() {
        axios
          .post("/api/register", this.form)
          .then((response) => {
            localStorage.setItem("auth_token", response.data.token);           
            this.$router.push("/");
          })
          .catch((error) => {
            console.error("Registration error:", error);
          });
      },
    },
  };
  </script>
  