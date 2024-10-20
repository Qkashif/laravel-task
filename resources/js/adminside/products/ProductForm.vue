
<template>
    <div class="container mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            {{ isEditing ? 'Edit Product' : 'Add New Product' }}
        </h2>
        <form @submit.prevent="saveProduct" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input v-model="product.name" type="text" id="name"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded" required />
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input v-model="product.price" type="number" id="price"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded" required />
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea v-model="product.description" id="description"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded"></textarea>
            </div>
            <div class="mb-4">
                <label for="categories" class="block text-sm font-medium text-gray-700">Categories</label>
                <select v-model="product.categories" id="categories" multiple
                    class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    <option v-for="category in allCategories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <div class="mb-6">
                <label for="images" class="block text-sm font-medium text-gray-700">Images</label>
                <input type="file" id="images" multiple @change="handleImageUpload"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded" />
            </div>
            <button type="submit"
                class="w-full bg-indigo-500 text-white font-semibold py-2 rounded hover:bg-indigo-600 transition duration-300">
                {{ isEditing ? 'Update Product' : 'Create Product' }}
            </button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            product: {
                name: '',
                price: '',
                description: '',
                categories: [],
                images: [],
            },
            allCategories: [],
            isEditing: false,
        };
    },
    methods: {
        fetchCategories() {
            axios.get('/api/categories')
                .then(response => {
                    this.allCategories = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching categories:', error);
                });
        },
        fetchProduct() {
            const id = this.$route.params.id;
            if (id) {
                this.isEditing = true;
                axios.get(`/api/products/${id}`)
                    .then(response => {
                        const productData = response.data.data;
                        
                        this.product.name = productData.name;
                        this.product.price = productData.price;
                        this.product.description = productData.description;
                        this.product.categories = productData.categories.map(category => category.id);
                    })
                    .catch(error => {
                        console.error('Error fetching product:', error);
                    });
            }
        },
        handleImageUpload(event) {
            this.product.images = Array.from(event.target.files);
        },
        saveProduct() {
            const formData = new FormData();
            formData.append('name', this.product.name);
            formData.append('price', this.product.price);
            formData.append('description', this.product.description);

            this.product.categories.forEach(category => {
                formData.append('categories[]', category);
            });

            this.product.images.forEach((image, index) => {
                formData.append(`images[${index}]`, image);
            });

            const id = this.$route.params.id;
            const url = id ? `/api/products/${id}` : '/api/products';

            if (id) {
                formData.append('_method', 'PUT');
            }

            for (let pair of formData.entries()) {
                console.log(`${pair[0]}: ${pair[1]}`);
            }

            axios({
                method: 'post',
                url,
                data: formData,
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
                .then(() => {
                    this.$router.push('/admin/products');
                })
                .catch(error => {
                    console.error('Error saving product:', error);
                });
        },
    },
    mounted() {
        this.fetchCategories();
        this.fetchProduct();
    },
};
</script>