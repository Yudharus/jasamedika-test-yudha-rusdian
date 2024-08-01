<script setup>
import { reactive } from 'vue'
import axios from 'axios';
import { useRouter } from 'vue-router';

// State untuk formulir login
const state = reactive({
  name: '',
  password: ''
});

const router = useRouter();

// const login = async () => {
//   state.errorMessage = ''; // Reset pesan kesalahan
//   try {
//     const response = await axios.post('http://127.0.0.1:8000/api/login', {
//       name: email.value,
//       password: password.value
//     })

//     if (response.data.status === 200) {
//       localStorage.setItem('dataUser', JSON.stringify(response.data.data))
//       router.push({ name: 'home' })
//     } else {
//       errorMessage.value = response.data.message
//     }
//   } catch (error) {
//     errorMessage.value = 'Login failed. Please try again.'
//   }
// }

const login = async () => {
  state.errorMessage = ''; // Reset pesan kesalahan
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/login', {
      name: state.name,
      password: state.password
    });
    
    if (response.data.status === 200) {
      localStorage.setItem('dataUser', JSON.stringify(response.data.data))
      router.push({ name: 'home' })
    }
  } catch (error) {
    if (error.response && error.response.data) {
      state.errorMessage = error.response.data.message || 'Login gagal: Terjadi kesalahan';
    } else {
      state.errorMessage = 'Login gagal: Terjadi kesalahan jaringan';
    }
    console.error('Login error:', error.response ? error.response.data : error.message);
  }
};
</script>

<template>
  <div class="items-center flex">
    <div class="w-1/2 h-screen bg-white items-center justify-between p-12">
      <h1 class="font-bold text-4xl text-primary--500 mb-2">MORENT | LOGIN</h1>
      <p class="text-base font-medium text-secondary--300">Welcome back! Please login to your account.</p>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Name</p>
        <input v-model="state.name" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input your name" type="text"/>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300">
        <p class="text-sm font-medium text-black">Password</p>
        <input v-model="state.password" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input your password" type="password"/>
      </div>
      <div v-if="state.errorMessage" class="text-red-500 mt-4">
        <p>{{ state.errorMessage }}</p>
      </div>
      <div class="mt-8 flex">
        <div @click="login" class="rounded-md w-24 p-4 items-center justify-center flex bg-primary--500 mr-8 cursor-pointer">
          <p class="text-sm font-medium text-white">Login</p>    
        </div>
        <RouterLink to="/register">
          <div class="rounded-md w-24 p-4 items-center justify-center flex bg-white border border-primary--500 cursor-pointer">
            <p class="text-sm font-medium text-primary--500">Sign Up</p>
          </div>
        </RouterLink>
      </div>
    </div>
    <div class="w-1/2 h-full items-center justify-center flex">
      <img src="../../assets/terios.png" class="w-3/4 h-3/4"/>
    </div>
  </div>
</template>
