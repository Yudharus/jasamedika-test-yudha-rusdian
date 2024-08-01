<script setup>
import { ref } from 'vue'
import TopBar from '../molecule/TopBar.vue';
import CardAds1 from '../organism/CardAds1.vue';
import CardAds2 from '../organism/CardAds2.vue';
import CardCatalog from '../organism/CardCatalog.vue';
import { reactive, onMounted } from 'vue';
import axios from 'axios';
import CardOnGoingRent from '../organism/CardOnGoingRent.vue';
import CardHistoryRent from '../organism/CardHistoryRent.vue';


defineProps({
  msg: String,
})

const state = reactive({
  items: [],
  onGoingRent : [],
  historyRent : []
});

const userDataString = localStorage.getItem('dataUser');
    const userData = JSON.parse(userDataString);
    const userId = userData.user.id;

const initData = async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/cars');
    const onGoingRentCar = await axios.get(`http://127.0.0.1:8000/api/ongoing-rental/${userId}`);
    const historyRentCar = await axios.get(`http://127.0.0.1:8000/api/history-rental/${userId}`);

    console.log(historyRentCar)
    state.items = response.data.data;
    state.onGoingRent = onGoingRentCar.data.data
    state.historyRent = historyRentCar.data.data
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  initData();
});
</script>

<template>
  <div class=" items-center justify-between pb-10">
    <TopBar/>      
    <div class="flex items-center justify-evenly">
        <CardAds1 />    
        <CardAds2 />    
    </div>
    <div class="mt-20 px-28">
      <h1 class="font-bold text-lg text-primary--500">On Going Rent</h1>
        <div class="items-center justify-center flex mt-12 ">
          <div class="flex grid grid-cols-4 gap-4 items-center justify-center">
            <CardOnGoingRent v-for="item in state.onGoingRent" :key="item.id" :item="item" />
          </div>
        </div>
    </div>
    <div class="mt-20 px-28">
      <h1 class="font-bold text-lg text-primary--500">History Rent</h1>
        <div class="items-center justify-center flex mt-12 ">
          <div class="flex grid grid-cols-4 gap-4 items-center justify-center">
            <CardHistoryRent v-for="item in state.historyRent" :key="item.id" :item="item" />
          </div>
        </div>
    </div>
    <div class="mt-20 px-28">
      <h1 class="font-bold text-lg text-primary--500">Available Car for Rent</h1>
        <div class="items-center justify-center flex mt-12 ">
          <div class="flex grid grid-cols-4 gap-4 items-center justify-center">
            <CardCatalog v-for="item in state.items" :key="item.id" :item="item" />
          </div>
        </div>
    </div>
    
  </div>

</template>

