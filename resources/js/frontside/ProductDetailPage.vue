<template>
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ product.name }}</h2>
        <p class="text-gray-700 mb-4">{{ product.description }}</p>
        <h3 class="text-2xl font-semibold text-gray-800 mt-6">Comments</h3>
        <div class="bg-gray-50 p-4 rounded mt-4">
            <div v-for="comment in comments" :key="comment.id" class="mb-4">
                <p class="text-gray-700">
                    <strong>{{ comment.user_name }}</strong> said
                    <span class="text-gray-500 text-sm">- {{ comment.created_at }}</span>
                </p>
                <p class="text-gray-600 mt-1">{{ comment.body }}</p>
                <hr class="my-2">
            </div>
            <div v-if="comments.length === 0" class="text-gray-600">No comments</div>
        </div>
        <div class="mt-6">
            <h3 class="text-2xl font-semibold text-gray-800">Leave a Comment</h3>
            <form @submit.prevent="submitComment" class="bg-white p-4 rounded shadow mt-4">
                <textarea v-model="newComment" placeholder="Write your comment here..."
                    class="w-full p-2 border rounded focus:outline-none" required></textarea>
                <button type="submit"
                    class="bg-indigo-500 text-white font-semibold px-4 py-2 rounded hover:bg-indigo-600 transition duration-300 mt-4">
                    Submit Comment
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            product: {},
            comments: [],
            newComment: '',
        };
    },
    methods: {
        fetchProduct() {
            const productId = this.$route.params.id;
            axios.get(`/api/products/${productId}`)
                .then(response => {
                    this.product = response.data.data;
                    this.comments = response.data.data.comments;
                })
                .catch(error => {
                    console.error('Error fetching product:', error);
                });
        },
        submitComment() {
            const productId = this.$route.params.id;
            const commentData = {
                body: this.newComment,
            };
            const token = localStorage.getItem('auth_token');
            axios.post(`/api/products/${productId}/comments`, commentData, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            })
                .then(response => {
                    this.comments.push(response.data.data);
                    this.comments.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    this.newComment = '';
                })
                .catch(error => {
                    console.error('Error submitting comment:', error);
                });
        }

    },
    mounted() {
        this.fetchProduct();
    },
};
</script>