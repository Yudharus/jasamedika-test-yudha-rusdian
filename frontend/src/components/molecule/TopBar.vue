<script setup>
import { ref } from 'vue'

const logout = () => {
  // Menghapus data otentikasi dari localStorage
  localStorage.removeItem('dataUser')
  
  // Mengarahkan pengguna ke halaman login
  router.push({ name: 'login' })
}
</script>

<template>
  <div class="w-full h-20 bg-white items-center justify-between p-6 flex">
    <div class="flex items-center">
      <h1 class="font-bold text-lg text-primary--500">MORENT</h1>
      <div class="h-10 rounded-md ml-28 rounded-full p-3 items-center justify-between flex border border-slate-400">
          <img src="../../assets/search-normal.png" class="w-4 h-4"/>
          <input class="w-full font-medium text-sm text-slate-400	ml-4 outline-none" placeholder="Search Car Here..."/>
      </div>
    </div>
    <div class="flex items-center justify-between ">
      <RouterLink to="/add-car">
      <div class="flex w-[120px] items-center justify-center rounded-md p-3 bg-primary--500 cursor-pointer mr-14 pointer-click">
        <img src="../../assets/add-button.png" class="w-6 h-6 mr-2"/>
        <p class="text-sm font-medium text-white">Add Car</p>
      </div>
    </RouterLink>
      <RouterLink to="/add-car">
      <div @click="logout" class="flex w-[120px] items-center justify-center rounded-md p-3 bg-white border border-primary--500 cursor-pointer mr-14 pointer-click">
        <p class="text-sm font-medium text-black">Logout</p>
      </div>
    </RouterLink>

      <img src="../../assets/user.png" class="w-11 h-11 rounded-full"/>
    </div>
  </div>

</template>

