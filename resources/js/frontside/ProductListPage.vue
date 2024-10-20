<template>   
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Our Products</h2>

        <!-- Display message when there are no products -->
        <div v-if="products.length === 0" class="text-center text-gray-600">
            There's no product added by the admin.
        </div>

        <!-- Display product cards when products exist -->
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="product in products" :key="product.id"
                class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition duration-300">
                <img :src="product.images.length ? `/storage/${product.images[0]}` : ''"
                    alt="Product Image" class="w-full h-48 object-cover rounded-t-lg" />
                <div class="mt-4">
                    <h3 class="text-xl font-semibold text-gray-800">{{ product.name }}</h3>
                    <p class="text-gray-600 mt-2 mb-4">
                        {{ product.description.length > 100 ? product.description.slice(0, 100) + '...' : product.description }}
                    </p>
                    <router-link :to="'/products/' + product.id"
                        class="inline-block bg-indigo-500 text-white font-semibold px-4 py-2 rounded-lg shadow hover:bg-indigo-600 transition duration-300">
                        View Details
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

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
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                });
        },
    },
    mounted() {
        this.fetchProducts();
    },
};
</script>
