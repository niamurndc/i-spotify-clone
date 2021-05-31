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
          <div class="w-10/12 bg-gray-800 py-4 px-8">
            <Header></Header>

          </div>


        </div>
    </div>
</template>

<script>
import Header from './blocks/Header.vue'
  export default {
    components: {
      Header,
    },
    data(){
      return{
        name: '',
        email: '',
        token: '',
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
          .then(res => console.log(123))
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

    }
  }
</script>