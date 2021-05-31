<template>
  <div class="py-2 mt-12">
    <div class="rounded bg-gray-900 text-gray-300 p-6 flex justify-start">
      <img :src="artist.image" class="mb-3 rounded-full h-24 w-24 object-cover">
      <div class="div ml-4 flex flex-col justify-center">
        <h1 class="text-2xl font-semibold">{{artist.name}}</h1>
        <h4 class="text-lg font-semibold">Artist</h4>
        <button @click="goBack" class="rounded bg-blue-500 px-2 py-1 mt-3">All Artist</button>
      </div>

    </div>

    <div class="mt-8 flex justify-start py-4">
      <div v-for="song in allsongs" :key="song.id" class="rounded mr-4 w-6/12 sm:4/12 md:3/12 lg:w-2/12 bg-gray-900 p-3 cursor-pointer" @click="$emit('playSong', song.id)">
        <img :src="song.image" alt="" class="mb-3 rounded h-24 w-full object-cover">
        <p class="font-semibold text-sm text-gray-200">{{song.title}}</p>
        <p class="text-xs text-gray-400">{{song.album}}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['token', 'id'],
  data(){
    return{
      artist: {},
      allsongs: [],
      newtoken: this.token,
      artistid: this.id,
    }
  },
  mounted() {
    this.getAlbum()
  },

  methods: {
    getAlbum(){
      axios.get(`http://localhost:8000/api/artist/${this.artistid}`, {headers:{
        'Content-Type': 'application/json',
        'Accept': 'application/json', 
        'Authorization': 'Bearer '+this.newtoken,}})
        .then(res => {
          this.artist = res.data
          this.getSongs(this.artist.name)
        })
        .catch(err => console.log(err))
    },

    getSongs(name){
      axios.get(`http://localhost:8000/api/song/search/artist/${name}`, {headers:{
        'Content-Type': 'application/json',
        'Accept': 'application/json', 
        'Authorization': 'Bearer '+this.newtoken,}})
        .then(res => {
          this.allsongs = res.data
        })
        .catch(err => console.log(err))
    },

    goBack(){
      this.$emit('goBack')
    }
  }
}
</script>