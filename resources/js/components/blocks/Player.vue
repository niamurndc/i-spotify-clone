<template>
  <div class="absolute bottom-0 left-0 border-t border-gray-700 bg-gray-800 w-full text-gray-200 z-50">
    <div class="flex px-6 py-4 aligns-cener">

      <div class="w-1/3 flex justify-start items-center">
        <img :src="coverImage" class="rounded-full w-16 h-16">
        <div class="div pl-4">
          <p class="font-semibold">{{title}}</p>
          <p class="text-sm">{{artist}}</p>
        </div>
        
      </div>

      <div class="w-1/3 flex justify-between px-8 items-center">
          <i class="fa fa-heart cursor-pointer"></i>
          <i @click="playPrev" class="fa fa-step-backward cursor-pointer"></i>

          <span class="text-4xl text-blue-500 mt-0">
            <i v-if="play" @click="pauseSong" class="fa fa-pause-circle cursor-pointer"></i>
            <i v-else @click="playSong" class="fa fa-play-circle cursor-pointer"></i>
          </span>
          

          <i @click="playNext" class="fa fa-step-forward cursor-pointer"></i>

          <i v-if="list==1" class="fa fa-refresh cursor-pointer"></i>
          <i v-else-if="list==2" class="fa fa-bars cursor-pointer"></i>
          <i v-else class="fa fa-repeat cursor-pointer"></i>   
      </div>


      <div class="w-1/3 flex justify-end items-center pr-8">
        <i @click="volumeDown" class="fa fa-volume-down cursor-pointer"></i>
        <div class="bg-gray-300 w-40 h-1 mx-2 cursor-pointer">
          <div :class="volumeClass"></div>
        </div>
        <i @click="volumeUp" class="fa fa-volume-up cursor-pointer"></i>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: ['id'],
  data(){
    return{
      volume: 10,
      title: '',
      artist: '',
      coverImage: '',
      play: false,
      list: 1,
      player: new Audio(),
      songid: this.id,
      song: '',
      token: '',
      volumeClass: '',
    }
  },
  created(){
    this.token = localStorage.getItem('token')
  },
  mounted(){
    this.getSong(this.songid)
    this.volumeClass = `bg-blue-500 w-${this.volume / 2}/5 h-1`
  },

  methods: {
    async getSong(id){
      this.song = null

      const response = await axios.get(`http://localhost:8000/api/song/${id}`, {headers:{
        'Content-Type': 'application/json',
        'Accept': 'application/json', 
        'Authorization': 'Bearer '+this.token,}})

      try {

        this.song = await response.data.audio
        this.title = await response.data.title
        this.artist = await response.data.artist
        this.coverImage = await response.data.image

        if(this.song != null){
          this.playSong()
        }else{
          this.pauseSong()
        }

      } catch (error) {
        console.log(error)
      }
    },

    

    pauseSong(){
      this.player.src = this.song
      this.player.pause()
      this.play = false
    },

    playNext(){
      const cid = this.songid + 1   
      this.getSong(cid)
      this.songid = cid
    },

    playPrev(){
      const cid = this.songid - 1
      this.getSong(cid)
      this.songid = cid
    },

    playSong(){
      if(this.song != null){
        this.player.src = this.song
        this.player.play()
        this.play = true
      }

      
    },

    volumeUp(){
      if(this.volume < 10){
        this.volume += 2
        const sound = this.volume * 0.10
        this.player.volume = sound 
        this.volumeClass = `bg-blue-500 w-${this.volume / 2}/5 h-1`
      }
    },

    volumeDown(){
      if(this.volume > 0){
        this.volume -= 2
        const sound = this.volume * 0.10
        this.player.volume = sound
        if(this.volume == 0){
          this.volumeClass = `bg-blue-500 hidden h-1`
        }else{
          this.volumeClass = `bg-blue-500 w-${this.volume / 2}/5 h-1`
        }
        
      }
    },
      
  },

  destroyed(){
    this.pauseSong()
  }
}
</script>
