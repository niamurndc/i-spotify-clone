<template>
    <div class="w-full">

        <div class="flex">
          <div class="sidebar bg-gray-900 text-white px-6 py-4 lg:w-2/12 min-h-screen">
            <h2 class="text-xl text-blue-400">Zajira Tune</h2>

            <div class="mt-12">
              <router-link to="/admin-home" class="block py-2 text-md font-semibold">Home</router-link>
              <router-link to="/admin-artist" class="block py-2 text-md font-semibold">Artist</router-link>
              <router-link to="/admin-album" class="block py-2 text-md font-semibold">Album</router-link>
              <router-link to="/admin-song" class="block py-2 text-md font-semibold">Songs</router-link>
            </div>
            
          </div>
        

          <!-- main area -->
          <div class="w-10/12 bg-gray-800 py-4 px-8 relative">

            <!-- model -->
            <div v-if="deleteModal" class="rounded bg-gray-900 text-gray-300 px-4 py-6 w-1/3 absolute top-1/3 right-1/3 z-40 text-center">
              <p class="text-lg font-semibold">Do you want to delete this item?</p>
              <div class="flex justify-evenly mt-6">
                <button @click="hideModal" class="rounded bg-blue-500 text-black px-4 text-lg py-2">Cancel</button>
                <button @click="deleteSong" class="rounded bg-red-500 text-black px-4 text-lg py-2">Delete</button>
              </div>
            </div>
            <!-- modal end -->


            <Header></Header>
            <div class="mt-6 w-full p-4">
              <h1 class="text-2xl font-bold text-gray-300">Songs</h1>

              <div class="rounded border border-gray-700 p-3 text-gray-300 my-8">
                <h2 class="text-xl font-semibold pl-4">Add song</h2>
                <div class="flex justify-between py-3">
                  <div class="px-2 w-1/3">
                    <input type="text" v-model="title" class="rounded border border-gray-700 bg-gray-900 text-gray-300 px-2 py-2 w-full" placeholder="Song title">
                  </div>
                  <div class="px-2 w-1/3">
                    <select v-model="artist" class="rounded border border-gray-700 bg-gray-900 text-gray-300 px-2 w-full pb-1 pt-2">
                      <option value="">Select artist</option>
                      <option v-for="artist in allartist" :key="artist.id" :value="artist.name">{{artist.name}}</option>
                    </select>
                  </div>
                  <div class="px-2 w-1/3">
                    <input type="file" @change="fileUpload" class="rounded border border-gray-700 bg-gray-900 text-gray-300 px-2 w-full pb-1 pt-2">
                  </div>
                </div>
                <div class="flex justify-between py-3">
                  <div class="px-2 w-1/3">
                    <select v-model="album" class="rounded border border-gray-700 bg-gray-900 text-gray-300 px-2 w-full pb-1 pt-2">
                      <option value="">Select album</option>
                      <option v-for="album in allalbums" :key="album.id" :value="album.title">{{album.title}}</option>
                    </select>
                  </div>
                  <div class="px-2 w-1/3">
                    <input type="file" @change="fileAudioUpload" class="rounded border border-gray-700 bg-gray-900 text-gray-300 px-2 w-full pb-1 pt-2">
                  </div>
                  <div class="px-2 w-1/3">
                    <button v-if="update" @click="updateSong" class="rounded bg-blue-500 text-black px-2 py-2">Update</button>
                    <button v-else @click="addSong" class="rounded bg-blue-500 text-black px-2 py-2">Add New</button>
                  </div>
                </div>
              </div>

              <div v-for="song in allsongs" :key="song.id" class="flex justify-between items-center rounded border border-gray-700 text-gray-300 p-2 mt-2">
                <div class="flex justify-start items-center w-6/12">
                  <img :src="song.image" alt="" class="rounded-full h-8 w-8 cursor-pointer">
                  <h2 class="text-lg font-semibold pl-4">{{song.title}}</h2>
                  <p class="ml-4">By: {{song.artist}}</p>
                  <p class="ml-4">Album: {{song.album}}</p>
                </div>
                <div class="p-1 w-4/12">
                  <audio controls class="">
                    <source :src="song.audio" type="audio/mpeg">
                  </audio>
                </div>
                <div class="flex justify-end items-center w-2/12">
                  <i @click="showEditSong(song.id, song.title, song.artist, song.album)" class="fa fa-pencil pr-3 cursor-pointer text-lg"></i>
                  <i @click="showDeleteSong(song.id)" class="fa fa-trash pr-2 cursor-pointer text-lg"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
import Header from '../blocks/Header.vue'
  export default {
    components: {
      Header,
    },
    data(){
      return{
        title: '',
        image: '',
        audio: '',
        artist: '',
        album: '',
        token: '',
        allartist: [],
        allalbums: [],
        allsongs: [],
        deleteModal: false,
        setId: null,
        update: false,
      }
    },
    created(){

      this.token = localStorage.getItem('token')

      if(this.token == null){
        this.$router.push({name: 'Login'})
      }else{
        axios.get('http://localhost:8000/api/profile', {headers:{
          'Content-Type': 'application/json',
          'Accept': 'application/json', 
          'Authorization': 'Bearer '+this.token,}})
          .then(res => console.log(123))
          .catch(err => {
            if(err.response.status == 401){
              this.$router.push({name: 'Login'})
              this.$toasted.error("Your token is invalid", {
                duration: 3000,
              });
            }
          })
      }
    },
    mounted() {
      this.getArtists()
      this.getAlbums()
      this.getSongs()
    },

    methods: {
      
      addSong(){
        if(this.title == '' || this.audio == ''){
          this.$toasted.error("Title & audio is required", {
            duration: 3000,
          });
        }else{
          const fd = new FormData()
          fd.append('image', this.image)
          fd.append('audio', this.audio)
          fd.append('title', this.title)
          fd.append('artist', this.artist)
          fd.append('album', this.album)

          const config = {
            headers:{
            'Content-Type': 'application/json',
            'Accept': 'application/json', 
            'Authorization': 'Bearer '+this.token,}
          }

          axios.post('http://localhost:8000/api/song/create', fd, config)
            .then(res => {
              this.$toasted.success("Album added", {
                duration: 3000,
              });
              this.getSongs()
            })
            .catch(err => console.log(err))
        }
      },

      getArtists(){
        axios.get('http://localhost:8000/api/artist', {headers:{
          'Content-Type': 'application/json',
          'Accept': 'application/json', 
          'Authorization': 'Bearer '+this.token,}})
          .then(res => {
            this.allartist = res.data
          })
          .catch(err => console.log(err))
      },

      getAlbums(){
        axios.get('http://localhost:8000/api/album', {headers:{
          'Content-Type': 'application/json',
          'Accept': 'application/json', 
          'Authorization': 'Bearer '+this.token,}})
          .then(res => {
            this.allalbums = res.data
          })
          .catch(err => console.log(err))

      },

      getSongs(){
        axios.get('http://localhost:8000/api/song', {headers:{
          'Content-Type': 'application/json',
          'Accept': 'application/json', 
          'Authorization': 'Bearer '+this.token,}})
          .then(res => {
            this.allsongs = res.data
          })
          .catch(err => console.log(err))

          this.clearData()
      },

      fileUpload(e){
        const file = e.target.files[0]
        this.image = file
      },

      fileAudioUpload(e){
        const file = e.target.files[0]
        this.audio = file
      },

      showEditSong(id, title, artist, album){
        this.setId = id
        this.update = true
        this.title = title
        this.artist = artist
        this.album = album
      },

      updateSong(){
        if(this.title == ''){
          this.$toasted.error("Title is required", {
            duration: 3000,
          });
        }else{
          const fd = new FormData()
          fd.append('image', this.image)
          fd.append('title', this.title)
          fd.append('artist', this.artist)
          fd.append('album', this.album)

          const config = {
            headers:{
            'Content-Type': 'application/json',
            'Accept': 'application/json', 
            'Authorization': 'Bearer '+this.token,}
          }

          axios.post(`http://localhost:8000/api/song/update/${this.setId}`, fd, config)
            .then(res => {
              this.$toasted.success("Song updated", {
                duration: 3000,
              });
              this.getSongs()
              this.update = false
            })
            .catch(err => console.log(err))
        }
      },

      showDeleteSong(id){
        this.setId = id
        this.deleteModal = true
      },

      hideModal(){
        this.setId = null
        this.deleteModal = false
      },

      deleteSong(){
        axios.delete(`http://localhost:8000/api/song/delete/${this.setId}`, {headers:{
          'Content-Type': 'application/json',
          'Accept': 'application/json', 
          'Authorization': 'Bearer '+this.token,}})
          .then(res => {
            this.$toasted.success("Song deleted", {
              duration: 3000,
            });
            this.getSongs()
            this.deleteModal = false
          })
          .catch(err => console.log(err))
      },

      clearData(){
        this.title = ''
        this.image = null
        this.audio = null
        this.artist = ''
        this.album = ''
      }
    }
  }
</script>