// resources/js/app.js
import { createApp } from 'vue';
import router from './router';
import App from './App.vue';
import '../css/app.css';
import axios from 'axios'; 

axios.defaults.baseURL = '/';

const token = localStorage.getItem('auth_token');
if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

const app = createApp(App);
app.use(router);

app.config.globalProperties.$axios = axios;

axios.interceptors.response.use(
    response => response,
    error => {
      if (error.response && error.response.status === 401) {

        localStorage.removeItem('auth_token');
        router.push('/login');
      }
      return Promise.reject(error);
    }
  );

app.mount('#app');
