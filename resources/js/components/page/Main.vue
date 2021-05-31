<template>
  <div class="main">
    <div class="genra py-2 mt-12">
      <h1 class="text-2xl font-bold text-gray-200">Latest Music</h1>
      <div class="flex justify-start py-4">
        <div v-for="song in allsongs" :key="song.id" class="rounded mr-4 w-6/12 sm:4/12 md:3/12 lg:w-2/12 bg-gray-900 p-3 cursor-pointer" @click="startPlaying(song.id)">
          <img :src="song.image" alt="" class="mb-3 rounded h-24 w-full object-cover">
          <p class="font-semibold text-sm text-gray-200">{{song.title}}</p>
          <p class="text-xs text-gray-400">{{song.artist}}</p>
        </div>
      </div>
    </div>

    <div class="genra py-2 mt-12">
      <h1 class="text-2xl font-bold text-gray-200">Latest Music</h1>
      <div class="flex justify-start py-4">
        <div v-for="song in allsongs" :key="song.id" class="rounded mr-4 w-6/12 sm:4/12 md:3/12 lg:w-2/12 bg-gray-900 p-3 cursor-pointer" @click="startPlaying(song.id)">
          <img :src="song.image" alt="" class="mb-3 rounded h-24 w-full object-cover">
          <p class="font-semibold text-sm text-gray-200">{{song.title}}</p>
          <p class="text-xs text-gray-400">{{song.artist}}</p>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  props: ['token'],
  data(){
    return{
      allsongs: [],
      newtoken: this.token
    }
  },
  mounted() {
    this.getSongs()
  },

  methods: {
    getSongs(){
      axios.get('http://localhost:8000/api/song', {headers:{
        'Content-Type': 'application/json',
        'Accept': 'application/json', 
        'Authorization': 'Bearer '+this.newtoken,}})
        .then(res => {
          this.allsongs = res.data
        })
        .catch(err => console.log(err))
    },

    startPlaying(id){
      this.$emit('playSong', id)
    }
  }
}
</script>