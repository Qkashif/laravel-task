<template>
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <div class="flex space-x-4">
                <button @click="goHome"
                    class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition duration-300">
                    Go to Home
                </button>
                <button @click="logout"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-300">
                    Logout
                </button>
            </div>
        </header>
        <main class="flex-grow container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <router-link to="/admin/categories"
                    class="bg-white rounded-lg shadow p-6 text-center hover:shadow-lg transition duration-300">
                    <h2 class="text-xl font-semibold text-gray-800">Manage Categories</h2>
                    <p class="text-gray-600 mt-2">Create, edit, and manage product categories.</p>
                </router-link>
                <router-link to="/admin/products"
                    class="bg-white rounded-lg shadow p-6 text-center hover:shadow-lg transition duration-300">
                    <h2 class="text-xl font-semibold text-gray-800">Manage Products</h2>
                    <p class="text-gray-600 mt-2">Create, edit, and manage products.</p>
                </router-link>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    methods: {
        logout() {
            localStorage.removeItem('auth_token');
            this.$router.push('/');
        },
        goHome() {
            this.$router.push('/');
        },
    },
};
</script>