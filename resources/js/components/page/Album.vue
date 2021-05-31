<template>
  <div class="main">

    <div v-if="view" class="view">
      <Viewalbum v-bind:id="albumid" v-bind:token="newtoken" v-on:playSong="starPlay" v-on:goBack="goBack" />
    </div>


    <div v-else class="genra py-2 mt-12">
      <h1 class="text-2xl font-bold text-gray-200">All Albums</h1>
      <div class="flex justify-start py-4">
        <div v-for="album in allalbum" :key="album.id" class="rounded mr-4 w-6/12 sm:4/12 md:3/12 lg:w-2/12 text-center flex flex-col items-center p-3 cursor-pointer" @click="viewAlbum(album.id)">
          <img :src="album.image" class="mb-3 rounded-full h-32 w-32 object-cover">
          <p class="font-semibold text-sm text-gray-200">{{album.title}}</p>
          <p class="text-xs text-gray-200">Album</p>
        </div>
      </div>
    </div>

    
    
  </div>
</template>

<script>
import Viewalbum from './Viewalbum.vue'
export default {
  components: { Viewalbum },
  props: ['token'],
  data(){
    return{
      allalbum: [],
      newtoken: this.token,
      view: false,
      albumid: null
    }
  },
  mounted() {
    this.getAlbums()
  },

  methods: {
    getAlbums(){
      axios.get('http://localhost:8000/api/album', {headers:{
        'Content-Type': 'application/json',
        'Accept': 'application/json', 
        'Authorization': 'Bearer '+this.newtoken,}})
        .then(res => {
          this.allalbum = res.data
        })
        .catch(err => console.log(err))
    },

    viewAlbum(id){
      this.albumid = id
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