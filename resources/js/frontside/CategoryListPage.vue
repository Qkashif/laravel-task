<template>
  <div class="container mx-auto py-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Product Categories</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div 
        v-for="category in categories" 
        :key="category.id" 
        class="bg-white p-4 rounded shadow hover:shadow-md transition duration-300 cursor-pointer"
        @click="fetchProducts(category.id)"
      >
        <h3 class="text-xl font-semibold text-indigo-600">{{ category.name }}</h3>
        <p class="text-gray-600">{{ category.description }}</p>
      </div>
    </div>

    <div v-if="products.length > 0" class="mt-8">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Products in {{ selectedCategoryName }}</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div 
          v-for="product in products" 
          :key="product.id" 
          class="bg-white p-4 rounded shadow hover:shadow-md transition duration-300"
        >
          <h3 class="text-xl font-semibold text-indigo-600">{{ product.name }}</h3>
          <p class="text-gray-600">{{ product.description }}</p>
          <router-link 
            :to="'/products/' + product.id"
            class="text-indigo-500 hover:text-indigo-700 mt-2 inline-block"
          >
            View Details
          </router-link>
        </div>
      </div>
    </div>

    <!-- Show message if no category -->
    <div v-else-if="categories && categories.length === 0" class="mt-8 text-gray-600 text-center">
      There's no cateogory added by the admin.
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      categories: [],
      products: [],
      selectedCategoryName: '',
    };
  },
  methods: {
    fetchCategories() {
      axios.get('/api/categories')
        .then(response => {
          this.categories = response.data.data;
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    },
    fetchProducts(categoryId) {
      axios.get(`/api/categories/${categoryId}/products`)
        .then(response => {
          this.products = response.data.data;
          const selectedCategory = this.categories.find(cat => cat.id === categoryId);
          this.selectedCategoryName = selectedCategory ? selectedCategory.name : 'Unknown Category';
        })
        .catch(error => {
          console.error('Error fetching products:', error);
        });
    },
  },
  mounted() {
    this.fetchCategories();
  },
};
</script>
