<template>
  <div class="pt-20">
    <div class="w-3/12 bg-gray-900 text-white mx-auto rounded py-6">
      <h1 class="text-2xl font-bold text-gray-200 text-center text-blue-500">Login</h1>
      <div class="flex justify-center aligns-center py-4">
        <div class="mt-4">
          <form @submit.prevent="loginUser">
            <p class="pl-2 font-semibold text-gray-200 mt-1">Email</p>
            <input type="email" v-model="email" class="rounded border border-gray-700 bg-gray-900 text-gray-300 px-2 py-2 w-full" placeholder="Email">
            <p class="pl-2 font-semibold text-gray-200 mt-3">Password</p>
            <input type="password" v-model="password" class="rounded border border-gray-700 bg-gray-900 text-gray-300 px-2 py-2 w-full" placeholder="Password">
            <button type="submit" class="mt-3 rounded px-2 py-2 bg-blue-500 text-black">Login</button>
          </form>
          <router-link to="/register" class="mt-4 text-center block py-2 text-md font-semibold text-blue-500">Create new account</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return{
        email: '',
        password: '',
      }
    },
    mounted() {
    },

    methods: {
      loginUser(){
        if(this.email == '' || this.password == ''){
          console.log('all fields  are required')
        }else{
          if(this.password.length <= 5){
            console.log('password larger then 6')
          }else{
            axios.post('http://localhost:8000/api/login', {
              'email': this.email,
              'password': this.password
            })
              .then(data => {
                localStorage.setItem('token', data.data.token)
                localStorage.setItem('name', data.data.user.name)
                localStorage.setItem('email', data.data.user.email)

                this.$router.push({name:'Home'})
              })
              .catch(err => console.log(err))
          }
        }
      }
    }
  }
</script>