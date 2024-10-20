<template>
    <div class="container mx-auto p-6 bg-white rounded shadow">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Products</h2>
        <router-link 
          to="/admin/products/create" 
          class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition duration-300"
        >
          Add New Product
        </router-link>
      </div>
      <table id="productTable" class="display min-w-full bg-white">
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Categories</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id">
            <td>{{ product.name }}</td>
            <td>{{ product.description }}</td>
            <td>
              <span v-for="category in product.categories" :key="category.id" class="mr-2">
                {{ category.name }}
              </span>
            </td>
            <td>
              <router-link :to="'/admin/products/' + product.id + '/edit'" class="text-indigo-600 hover:text-indigo-900">Edit</router-link>
              <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900 ml-2">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import 'datatables.net';
  
  export default {
    data() {
      return {
        products: [],
      };
    },
    methods: {
      fetchProducts() {
        axios.get('/api/products')
          .then(response => {
            this.products = response.data.data;
            this.$nextTick(() => {
              $('#productTable').DataTable();
            });
          })
          .catch(error => {
            console.error('Error fetching products:', error);
          });
      },
      deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
          axios.delete(`/api/products/${id}`)
            .then(() => {
              this.products = this.products.filter(product => product.id !== id);
              $('#productTable').DataTable().destroy();
              this.$nextTick(() => {
                $('#productTable').DataTable();
              });
            })
            .catch(error => {
              console.error('Error deleting product:', error);
            });
        }
      },
    },
    mounted() {
      this.fetchProducts();
    },
  };
  </script>
  