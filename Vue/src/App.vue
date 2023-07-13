<script setup>
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
</script>

<template>
  <div class="container">
    <Header @logout="logout()" @toggle-add-task='toggleAddTask' title="Task Tracker" :buttonName="showAddTask"/>
      <div v-if="homePage()">
        <router-view  @zero-tasks='turnOnAddTask()' :showAddTask="showAddTask"></router-view>
      </div>
      <div v-else>
        <router-view></router-view>
      </div>
    <Footer />
  </div>
</template>

<script>
export default {
  data(){
    return{
      showAddTask: false
    }
  },
  emits:['zero-tasks','logout'],
  methods: {
    toggleAddTask(){
      this.showAddTask = !this.showAddTask
    },
    turnOnAddTask(){
      this.showAddTask = true
    },
    homePage(){
      if(this.$route.path ==="/"){
        return true
      }
      return false
    }, 
    logout(){
      localStorage.clear()
      this.showAddTask= false
      this.$router.push('/login')
    },
  },
  
}
</script>



