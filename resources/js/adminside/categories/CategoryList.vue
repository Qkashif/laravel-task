<template>
  <div class="container mx-auto p-6 bg-white rounded shadow">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold text-gray-800">Categories</h2>
      <router-link 
        to="/admin/categories/create" 
        class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition duration-300"
      >
        Add New Category
      </router-link>
    </div>
    <table id="categoryTable" class="display">
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="category in categories" :key="category.id">
          <td>{{ category.name }}</td>
          <td>{{ category.description }}</td>
          <td>
            <router-link :to="'/admin/categories/' + category.id + '/edit'" class="text-indigo-600 hover:text-indigo-900">Edit</router-link>
            <button @click="deleteCategory(category.id)" class="text-red-600 hover:text-red-900 ml-2">Delete</button>
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
        categories: [],
      };
    },
    methods: {
      fetchCategories() {
        axios.get('/api/categories')
          .then(response => {
            this.categories = response.data.data;
            this.$nextTick(() => {
              $('#categoryTable').DataTable(); 
            });
          })
          .catch(error => {
            console.error('Error fetching categories:', error);
          });
      },
      deleteCategory(id) {
        if (confirm('Are you sure you want to delete this category?')) {
          axios.delete(`/api/categories/${id}`)
            .then(() => {
              this.categories = this.categories.filter(category => category.id !== id);
              $('#categoryTable').DataTable().destroy();
              this.$nextTick(() => {
                $('#categoryTable').DataTable();
              });
            })
            .catch(error => {
              console.error('Error deleting category:', error);
            });
        }
      },
    },
    mounted() {
      this.fetchCategories();
    },
  };
</script>
