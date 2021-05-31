<template>
    <div class="w-full">
        <div class="flex">
          <div class="sidebar bg-gray-900 text-white px-6 py-4 lg:w-2/12 min-h-screen">
            <h2 class="text-xl text-blue-400">M Tune</h2>

            <div class="mt-12">
              <p @click="viewPage(1)" class="block py-2 text-md font-semibold cursor-pointer"><i class="fa fa-home mr-3"></i> Home</p>
              <p @click="viewPage(2)" class="block py-2 text-md font-semibold cursor-pointer"><i class="fa fa-user mr-3"></i> Artist</p>
              <p @click="viewPage(3)" class="block py-2 text-md font-semibold cursor-pointer"><i class="fa fa-dot-circle-o mr-3"></i> Album</p>
              <p @click="viewPage(3)" class="block py-2 text-md font-semibold cursor-pointer"><i class="fa fa-heart mr-3"></i> Liked Song</p>
            </div>

            <div class="mt-8">
              <p class="block py-1 text-xs font-semibold text-blue-400 uppercase">Your Playlist</p>
              <a href="/" class="block py-2 text-md font-semibold">Morning</a>
              <a href="/" class="block py-2 text-md font-semibold">Night</a>
            </div>

            <button class="mt-8 border border-blue-400 text-blue-400 px-2 py-2 text-sm">Add new playlist</button>
            
          </div>
        

          <!-- main area -->
          <div class="w-10/12 bg-gray-800 py-4 px-8">
            <Header></Header>

            <div v-if="view==1" class="page">
              <Main v-bind:token="token" v-on:playSong="startPlaying"></Main>
            </div>

            <div v-else-if="view==2" class="page">
              <Artist v-bind:token="token" v-on:playSong="startPlaying"></Artist>
            </div>

            <div v-else-if="view==3" class="page">
              <Album v-bind:token="token" v-on:playSong="startPlaying"></Album>
            </div>
            

          </div>
        </div>

        <div v-if="playing">
          <Player v-bind:id="songid" />
        </div>
        
    </div>
</template>

<script>
import Header from './blocks/Header.vue'
import Player from './blocks/Player.vue'
import Main from './page/Main.vue'
import Artist from './page/Artist.vue'
import Album from './page/Album.vue'
export default {
  components: {
    Header,
    Player,
    Main,
    Artist,
    Album
  },
  data(){
    return{
      name: '',
      email: '',
      token: '',
      playing: false,
      songid: null,
      view: 1,
    }
  },
  created(){
    this.name = localStorage.getItem('name')
    this.email = localStorage.getItem('email')
    this.token = localStorage.getItem('token')

    if(this.token == null){
      this.$router.push({name: 'Login'})
    }else{
      axios.get('http://localhost:8000/api/profile', {headers:{
        'Content-Type': 'application/json',
        'Accept': 'application/json', 
        'Authorization': 'Bearer '+this.token,}})
        .then(res => {
          this.getSongs()
        })
        .catch(err => {
          if(err.response.status == 401){
            this.$router.push({name: 'Login'})
            console.log('your token is invalid')
          }
        })
    }
  },
  mounted() {
  },

  methods: {
    startPlaying(id){
      if(this.playing == true){
        this.songid = id
        this.playing = false
      }else{
        this.songid = id
        this.playing = true
      }
    },

    viewPage(no){
      this.view = no
    }

  }
}
</script>