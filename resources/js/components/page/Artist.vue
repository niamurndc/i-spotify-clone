<template>
  <div class="main">
    <div class="view" v-if="view">
      <Viewartist v-bind:id="artistid" v-bind:token="newtoken" v-on:playSong="starPlay" v-on:goBack="goBack" />
    </div>


    <div v-else class="genra py-2 mt-12">
      <h1 class="text-2xl font-bold text-gray-200">All Artists</h1>
      <div class="flex justify-start py-4">
        <div v-for="artist in allartist" :key="artist.id" class="rounded mr-4 w-6/12 sm:4/12 md:3/12 lg:w-2/12 text-center flex flex-col items-center p-3 cursor-pointer" @click="viewArtist(artist.id)">
          <img :src="artist.image" class="mb-3 rounded-full h-24 w-24 object-cover">
          <p class="font-semibold text-sm text-gray-200">{{artist.name}}</p>
          <p class="text-xs text-gray-200">Artist</p>
        </div>
      </div>
    </div>

    

  </div>
</template>

<script>
import Viewartist from './Viewartist.vue'
export default {
  components: { Viewartist },
  props: ['token'],
  data(){
    return{
      allartist: [],
      newtoken: this.token,
      view: false,
      artistid: null
    }
  },
  mounted() {
    this.getArtists()
  },

  methods: {
    getArtists(){
      axios.get('http://localhost:8000/api/artist', {headers:{
        'Content-Type': 'application/json',
        'Accept': 'application/json', 
        'Authorization': 'Bearer '+this.newtoken,}})
        .then(res => {
          this.allartist = res.data
        })
        .catch(err => console.log(err))
    },

    viewArtist(id){
      this.artistid = id
      this.view = true
    },

    goBack(){
      this.albumid = null
      this.view = false
    },

    starPlay(id){
      this.$emit('playSong', id)
    }
  }
}
</script>