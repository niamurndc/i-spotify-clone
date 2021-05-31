<template>
  <div class="py-2 mt-12">
    <h1 class="text-2xl font-bold text-gray-200">{{title}}</h1>
    <div class="flex justify-between py-4">
      <div class="rounded mr-2 text-center">
        <img src="/image/artist/artist-1622131049.jpg" alt="" class="rounded-full w-32 h-32">
        <p class="font-semibold text-gray-200 mt-1">Album</p>
        <p class="text-sm text-gray-400">Artist Name</p>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['title'],
    mounted() {
    }
  }
</script>