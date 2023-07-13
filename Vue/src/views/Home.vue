<script setup>
import Tasks from '../components/Tasks.vue';
import AddTask from '../components/AddTask.vue';
</script>


<template>
    <div v-if="showAddTask">
      <AddTask @add-task="addTask"/>
    </div>
    <div v-if="this.tasks.length!=0">
      <Tasks @toggle-reminder ="toggleReminder" @delete-task="deleteTask" :tasks="tasks"/>
    </div>
    <div v-else class="no-task">
      <h1>You have no Tasks</h1>
      <h3>Try add some :)</h3>
    </div>
</template>

<script>
export default {
    props:{
        showAddTask: Boolean
    },
    data() {
        return {
            tasks:[]
        }
    },
    emits:['zero-tasks'],
    methods: {
      async fetchData() {
        let token = localStorage.token
        const res = await fetch( "http://localhost:8000/api/index",{
          headers:{
            'Accept': 'application/json',
            'Content-type': 'application/json',
            'Authorization': 'Bearer '+token
          },
          
        })
        const data = await res.json()
        return data
      },

      async addTask(data){
        let rem = data['reminder'] ?  true : false
        let array = {
          "text": data['text'],
          "day": data['day'],
          "reminder": rem
        }
        let token = localStorage.token
        const res = await fetch('http://localhost:8000/api/create',{
          method:'POST',
          headers:{
            'Accept': 'application/json',
            'Content-type': 'application/json',
            'Authorization': 'Bearer '+ token
          },
          body: JSON.stringify(array),
        })
        this.tasks= await res.json()
      },

      async deleteTask(id){
        if(confirm("Are u sure?")){
          let array = {
          "id": id
          }
          let token = localStorage.token
          const res = await fetch(`http://localhost:8000/api/deleteTask`,{
            method:'DELETE',
            headers:{
            'Accept': 'application/json',
            'Content-type': 'application/json',
            'Authorization': 'Bearer '+ token
          },
          body: JSON.stringify(array),
          })
          res.status === 200 ? this.tasks = this.tasks.filter((task)=>task.id !==id) : null;
          this.tasksLength()
        }
      },
      
      async toggleReminder(id){
        let array = {
          "id": id
        }
        let token = localStorage.token
        this.tasks = this.tasks.map((task)=>task.id == id ? {...task,reminder: !task.reminder} : task)
        const res = await fetch(`http://localhost:8000/api/reminder`,{
            method:'PUT',
            headers:{
            'Accept': 'application/json',
            'Content-type': 'application/json',
            'Authorization': 'Bearer '+ token
          },
          body: JSON.stringify(array),
        })
        
      },
      
    },
    async created() {
      localStorage.token == null ? this.$router.push('Login') : null

      this.tasks= await this.fetchData()
      await this.tasksLength()

    },

    tasksLength(){
        if(this.tasks.length==0){
          this.$emit('zero-tasks')
        }
      },

}
</script>

<style scoped>
  .no-task{
    display: block;
    justify-content: center;
    text-align: center;
    border: 2px solid steelblue;
    padding: 30px;
    border-radius: 5px;
  }


  
</style>