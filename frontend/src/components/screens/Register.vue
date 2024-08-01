<script setup>
import { reactive } from 'vue'
import axios from 'axios';
import { useRouter } from 'vue-router';

const state = reactive({
  name: '',
  address: '',
  phone: '',
  licenseNumber: '',
  password: ''
});

const router = useRouter();

const register = async () => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/register', {
      name: state.name,
      address: state.address,
      phone: state.phone,
      license_number: state.licenseNumber,
      password: state.password
    });
   
    console.log('Registration success:', response.data);
    router.push('/login'); // Redirect ke halaman login
  } catch (error) {
   
    console.error('Registration error:', error.response.data);
  }
};
</script>

<template>
  <div class="items-center flex">
    <div class="w-1/2 h-screen bg-white items-center justify-between p-12">
      <h1 class="font-bold text-4xl text-primary--500 mb-2">MORENT | REGISTER</h1>
      <p class="text-base font-medium text-secondary--300">Register your account.</p>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Name</p>
        <input v-model="state.name" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input your name" type="text"/>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Address</p>
        <input v-model="state.address" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input your Address" type="text"/>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Phone</p>
        <input v-model="state.phone" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input your Phone" type="text"/>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Licensed Number</p>
        <input v-model="state.licenseNumber" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input your Licensed Number" type="text"/>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Password</p>
        <input v-model="state.password" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input your Password" type="password"/>
      </div>
      <div class="mt-8 flex">
        <div @click="register" class="rounded-md w-24 p-4 items-center justify-center flex bg-primary--500 mr-8 cursor-pointer">
          <p class="text-sm font-medium text-white">Register</p>    
        </div>
        <RouterLink to="/login">
          <div class="rounded-md w-24 p-4 items-center justify-center flex bg-white border border-primary--500 cursor-pointer">
            <p class="text-sm font-medium text-primary--500">Login</p>
          </div>
        </RouterLink>
      </div>
    </div>
    <div class="w-1/2 h-full items-center justify-center flex">
      <img src="../../assets/terios.png" class="w-3/4 h-3/4"/>
    </div>
  </div>
</template>
