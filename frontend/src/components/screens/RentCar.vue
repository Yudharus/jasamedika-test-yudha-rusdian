<script setup>
import { ref, watch, onMounted } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const carId = route.params.id;
const car = ref(null);
const state = ref({
  name: '',
  address: '',
  phone: '',
  licenseNumber: '',
  password: '',
  startDate: '',
  endDate: '',
  totalAmount: 0,
});
const errorMessage = ref('');

onMounted(async () => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/cars/${carId}`);
    car.value = response.data.data;
  } catch (error) {
    console.error('Error fetching car details:', error);
    errorMessage.value = 'Gagal mengambil data mobil.';
  }
});

watch(
  [() => state.value.startDate, () => state.value.endDate],
  () => {
    calculateTotalAmount();
  }
);

const calculateTotalAmount = () => {
  if (state.value.startDate && state.value.endDate && car.value) {
    const startDate = new Date(state.value.startDate);
    const endDate = new Date(state.value.endDate);
    const timeDiff = endDate - startDate;
    const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
    
    if (dayDiff >= 0) {
      state.value.totalAmount = dayDiff * car.value.daily_rate;
    } else {
      state.value.totalAmount = 0;
    }
  }
};
    
const rentCar = async () => {
    const userDataString = localStorage.getItem('dataUser');
    const userData = JSON.parse(userDataString);
    const userId = userData.user.id;
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/rental', {
      user_id: userId, 
      car_id: carId,
      start_date: state.value.startDate,
      end_date: state.value.endDate,
      total_amount: state.value.totalAmount,
    });
    if (response.data.status === 201) {
      router.push('/');
    } else {
      errorMessage.value = response.data.message || 'Gagal melakukan rental.';
    }
  } catch (error) {
    console.error('Error renting car:', error);
    errorMessage.value = error.response?.data?.message || 'Gagal melakukan rental. Silakan coba lagi.';
  }
};
</script>
<template>
    <div class="items-center flex">
      <div class="w-1/2 h-screen bg-white items-center justify-between p-12">
        <h1 class="font-bold text-4xl text-primary--500 mb-2">MORENT | RENT CAR</h1>
        <p class="text-base font-medium text-secondary--300">Rent the best car.</p>
  
        <div v-if="car" class="mt-8">
          <h2 class="text-xl font-bold">{{ car.brand }} - {{ car.model }}</h2>
          <p class="text-sm font-medium text-secondary--300">Rp {{ car.daily_rate }} / day</p>
  
          <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
            <p class="text-sm font-medium text-black">Start Date</p>
            <input v-model="state.startDate" class="w-full font-medium text-base text-primary--500 outline-none mt-2" type="date" />
          </div>
          <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
            <p class="text-sm font-medium text-black">End Date</p>
            <input v-model="state.endDate" class="w-full font-medium text-base text-primary--500 outline-none mt-2" type="date" />
          </div>
          <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
            <p class="text-sm font-medium text-black">Total Amount</p>
            <input class="w-full font-medium text-base text-primary--500 outline-none mt-2" type="number" :value="state.totalAmount" readonly />
          </div>
        </div>
  
        <div v-if="errorMessage" class="text-red-500 mt-4">
          {{ errorMessage }}
        </div>
        
        <div class="mt-8 flex">
          <div @click="rentCar" class="rounded-md w-24 p-4 items-center justify-center flex bg-primary--500 mr-8 cursor-pointer">
            <p class="text-sm font-medium text-white">Rent Now</p>
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
  