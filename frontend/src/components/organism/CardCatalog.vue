<script setup>
import { useRouter } from 'vue-router';
import { defineProps } from 'vue';

// Mendefinisikan props
const props = defineProps({
    item: Object
});

const router = useRouter();

const rentNow = () => {
    // Mengakses item melalui props
    router.push(`/rent-car/${props.item.id}`);
};
</script>

<template>
  <div class="w-[304px] h-[177px] rounded-md bg-white p-4">
    <div class="flex items-center justify-between w-full ">
        <p class="text-lg font-bold text-black">{{ props.item.model }}</p>
        <p class="text-sm font-medium text-secondary--300">{{ props.item.brand }}</p>
    </div>
    <div class="flex items-center justify-between mt-6">
        <div class="flex items-center ">
            <img src="../../assets/gas.png" class="w-6 h-6 mr-2"/>
            <p class="text-sm font-medium text-secondary--300">{{ props.item.gas }}L</p>
        </div>
        <div class="flex items-center ">
            <img src="../../assets/type-car.png" class="w-6 h-6 mr-2"/>
            <p class="text-sm font-medium text-secondary--300">{{ props.item.driving_type }}</p>
        </div>
        <div class="flex items-center ">
            <img src="../../assets/capacity.png" class="w-6 h-6 mr-2"/>
            <p class="text-sm font-medium text-secondary--300">{{ props.item.capacity }} People</p>
        </div>
    </div>
    <div class="flex items-center justify-between mt-6">
        <p class="text-xl font-bold text-black">Rp {{ props.item.daily_rate }}/day</p>
        <div @click="rentNow" class="flex items-center rounded-md p-3 bg-primary--500 cursor-pointer">
            <p class="text-sm font-medium text-white">Rent Now</p>
        </div>
    </div>
  </div>
</template>
