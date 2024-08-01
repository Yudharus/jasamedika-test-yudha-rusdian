<script setup>

defineProps({
  bgColor: String,
  imgBackground: String
})

</script>

<template>
  <div class="w-2/5 h-[360px] rounded-lg mt-8 bg-primary--500 relative">
    <img src="../../assets/bg-card-2.png" class="w-full h-full "/>
    <div class="absolute top-5 left-5">
      <p class="text-2xl font-bold text-white">Easy way to rent a<br>car at a low price</p>
      <p class="text-sm font-base text-white mt-4">Providing cheap car rental services<br>and safe and comfortable facilities.</p>
    </div>
  </div>
</template>

