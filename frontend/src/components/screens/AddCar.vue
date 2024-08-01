<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const state = reactive({
  brand: '',
  model: '',
  plateNumber: '',
  dailyRate: '',
  available: '',
  gas: '',
  drivingType: '',
  capacity: ''
})

const errorMessage = ref('');
const router = useRouter()

const addCar = async () => {
  try {
    const statAvailable = state.available.toString()
    const response = await axios.post('http://127.0.0.1:8000/api/add-car', {
      brand: state.brand,
      model: state.model,
      plate_number: state.plateNumber,
      daily_rate: state.dailyRate,
      available: statAvailable,
      gas: state.gas,
      driving_type: state.drivingType,
      capacity: state.capacity
    })
    
    if (response.data.status === 201) {
      console.log('Car added successfully:', response.data.data)
      // Redirect to another page or show success message
      router.push('/') // Redirect to home or another page after successful addition
    } else {
      console.error('Failed to add car:', response.data.message)
    }
  } catch (error) {
    if (error.response && error.response.data) {
      errorMessage.value = error.response.data.message || 'Terjadi kesalahan saat menambahkan mobil';
    } else {
      errorMessage.value = 'Terjadi kesalahan. Silakan coba lagi.';
    }
    console.error('Error adding car:', error.response ? error.response.data : error.message)
  }
}
</script>

<template>
  <div class="items-center flex ">
    <div class="w-1/2 h-screen bg-white items-center justify-between p-12">
      <h1 class="font-bold text-4xl text-primary--500 mb-2">MORENT | ADD CAR</h1>
      <p class="text-base font-medium text-secondary--300">Add a new car.</p>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Brand</p>
        <input v-model="state.brand" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input car brand" type="text"/>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Model</p>
        <input v-model="state.model" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input car model" type="text"/>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Plate Number</p>
        <input v-model="state.plateNumber" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input car plate number" type="text"/>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Daily Rate</p>
        <input v-model="state.dailyRate" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input daily rate" type="number"/>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Availability</p>
        <!-- <input v-model="state.available" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input availability" type="text"/> -->
        <input v-model="state.available" type="checkbox" class="mr-2"/>
        <span>{{ state.available ? 'Yes' : 'No' }}</span>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Gas</p>
        <input v-model="state.gas" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input gas consumption" type="number"/>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Driving Type</p>
        <input v-model="state.drivingType" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input driving type" type="text"/>
      </div>
      <div class="w-full p-2 border-2 border-secondary--300 mt-8 mb-4">
        <p class="text-sm font-medium text-black">Capacity</p>
        <input v-model="state.capacity" class="w-full font-medium text-base text-primary--500 outline-none mt-2" placeholder="Input capacity" type="number"/>
      </div>
      <div v-if="errorMessage" class="text-red-500 mb-4">
        {{ errorMessage }}
      </div>
      <div class="mt-8 pb-8 flex">
        <div @click="addCar" class="rounded-md w-24 p-4 items-center justify-center flex bg-primary--500 mr-8 cursor-pointer">
          <p class="text-sm font-medium text-white">Add Car</p>
        </div>
        <RouterLink to="/">
          <div class="rounded-md w-24 p-4 items-center justify-center flex bg-white border border-primary--500 cursor-pointer">
            <p class="text-sm font-medium text-primary--500">Back</p>
          </div>
        </RouterLink>
      </div>
    </div>
    <div class="w-1/2 h-full items-center justify-center flex">
      <img src="../../assets/terios.png" class="w-3/4 h-3/4"/>
    </div>
  </div>
</template>
