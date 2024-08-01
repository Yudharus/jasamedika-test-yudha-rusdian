<script setup>

defineProps({
  bgColor: String,
  imgBackground: String
})

</script>

<template>
  <div class="w-2/5 h-[360px] rounded-lg mt-8 bg-information--500 relative">
    <img src="../../assets/bg-card-1.png" class="w-fit h-fit"/>
    <div class="absolute top-5 left-5">
      <p class="text-2xl font-bold text-white">The Best Platform<br>for Car Rental</p>
      <p class="text-sm font-base text-white mt-4">Ease of doing a car rental safely and<br>reliably. Of course at a low price.</p>
    </div>
  </div>
</template>

