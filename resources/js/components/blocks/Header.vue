<template>
    <div class="header flex justify-between w-full items-center">
      <input type="text" class="rounded border border-gray-700 bg-gray-900 text-gray-300 px-2 py-2 w-80" placeholder="search for song or artist">
      <div class="flex justify-evenly items-center relative">

        <img @click="showBox" src="/image/artist/artist-1622131049.jpg" alt="" class="rounded-full h-8 w-8 cursor-pointer">
        <div v-if="logoutbox" class="absolute bg-gray-900 p-1 top-full right-0 w-32">
          <router-link to="/profile" class="text-gray-300 font-semibold block py-2 px-1 border-y border-gray-700 cursor-pointer">Profile</router-link>
          <router-link to="/admin" class="text-gray-300 font-semibold block py-2 px-1 border-y border-gray-700 cursor-pointer">Admin</router-link>
          <p @click="logout" class="text-gray-300 font-semibold block py-2 px-1 border-y border-gray-700 cursor-pointer">Logout</p>
        </div>
      </div>
    </div>
</template>

<script>
  export default {
    data(){
      return{
        logoutbox: false
      }
    },
    mounted() {
    },
    methods: {
      logout(){
        this.token = localStorage.getItem('token')

          axios.get('http://localhost:8000/api/logout', {headers:{
            'Content-Type': 'application/json',
            'Accept': 'application/json', 
            'Authorization': 'Bearer '+this.token,}})
            .then(res => {
              console.log('Logged out successful')
              this.$router.push({name: 'Login'})
            })
            .catch(err => console.log(err))
      },

      showBox(){
        this.logoutbox = !this.logoutbox
      }
    }
  }
</script>