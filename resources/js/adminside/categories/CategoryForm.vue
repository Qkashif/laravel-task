<template>
  <div class="container mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">
      {{ isEditing ? 'Edit Category' : 'Add New Category' }}
    </h2>
    <form @submit.prevent="saveCategory">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input v-model="category.name" type="text" id="name"
          class="mt-1 block w-full p-2 border border-gray-300 rounded" required />
      </div>
      <div class="mb-6">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea v-model="category.description" id="description"
          class="mt-1 block w-full p-2 border border-gray-300 rounded"></textarea>
      </div>
      <button type="submit"
        class="w-full bg-indigo-500 text-white font-semibold py-2 rounded hover:bg-indigo-600 transition duration-300">
        {{ isEditing ? 'Update Category' : 'Create Category' }}
      </button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      category: {
        name: '',
        description: '',
      },
      isEditing: false,
    };
  },
  methods: {
    fetchCategory() {
      const id = this.$route.params.id;
      if (id) {
        this.isEditing = true;
        axios.get(`/api/categories/${id}`)
          .then(response => {
            this.category = response.data.data;
          })
          .catch(error => {
            console.error('Error fetching category:', error);
          });
      }
    },
    saveCategory() {
      const id = this.$route.params.id;
      const url = id ? `/api/categories/${id}` : '/api/categories';
      const method = id ? 'put' : 'post';

      const token = localStorage.getItem('auth_token');
      console.log('Token:', token);

      axios({
        method: method,
        url: url,
        data: this.category,
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
        .then(() => {
          this.$router.push('/admin/categories');
        })
        .catch(error => {
          console.error('Error saving category:', error);
          if (error.response && error.response.data) {
            console.error('Error message:', error.response.data.message);
          }
        });
    }

  },
  mounted() {
    this.fetchCategory();
  },
};
</script>