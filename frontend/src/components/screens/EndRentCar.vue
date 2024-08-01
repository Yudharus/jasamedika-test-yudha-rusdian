<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const carId = route.params.id;
const car = ref(null);
const state = ref({
  rentals_id: '',
  plate_number: '',
});
const errorMessage = ref('');

// Ambil data mobil saat komponen dimuat
onMounted(async () => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/rental/${carId}`);
    car.value = response.data.data;
    state.value.rentals_id = car.value.id; // Set rentals_id dari data mobil
  } catch (error) {
    console.error('Error fetching car details:', error);
    errorMessage.value = 'Gagal mengambil data mobil.';
  }
});

// Fungsi untuk mengakhiri rental mobil
const endRentCar = async () => {
  try {
    const response = await axios.patch(`http://127.0.0.1:8000/api/rental/${state.value.rentals_id}`, {
      plate_number: state.value.plate_number,
    });
    
    if (response.data.status === 200) {
      router.push('/');
    } else {
      errorMessage.value = response.data.message || 'Gagal mengakhiri rental.';
    }
  } catch (error) {
    console.error('Error ending rent car:', error);
    errorMessage.value = error.response?.data?.message || 'Gagal mengakhiri rental. Silakan coba lagi.';
  }
};
</script>

<template>
  <div class="items-center flex">
    <div class="w-1/2 h-screen bg-white items-center justify-between p-12">
      <h1 class="font-bold text-4xl text-primary--500 mb-2">MORENT | END RENT CAR</h1>
      <p class="text-base font-medium text-secondary--300">End your rent.</p>

      <div v-if="car" class="mt-8">
        <h2 class="text-xl font-bold">{{ car.brand }} - {{ car.model }}</h2>
        <p class="text-sm font-medium text-secondary--300">Rp {{ car.total_amount }} / day</p>
        <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
          <p class="text-sm font-medium text-black">Number Plate</p>
          <input v-model="state.plate_number" class="w-full font-medium text-base text-primary--500 outline-none mt-2" type="text" />
        </div>
      </div>

      <div v-if="errorMessage" class="text-red-500 mt-4">
        {{ errorMessage }}
      </div>
      
      <div class="mt-8 flex">
        <div @click="endRentCar" class="rounded-md w-24 p-4 items-center justify-center flex bg-primary--500 mr-8 cursor-pointer">
          <p class="text-sm font-medium text-white">End Rent</p>
        </div>
        <RouterLink to="/">
          <div class="rounded-md w-24 p-4 items-center justify-center flex bg-white border border-primary--500 cursor-pointer">
            <p class="text-sm font-medium text-primary--500">Cancel</p>
          </div>
        </RouterLink>
      </div>
    </div>
    <div class="w-1/2 h-full items-center justify-center flex">
      <img src="../../assets/terios.png" class="w-3/4 h-3/4"/>
    </div>
  </div>
</template>
