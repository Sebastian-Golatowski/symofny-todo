<script setup>
import { computed } from '@vue/runtime-core';
    import Button from '../components/Button.vue';
</script>

<template>
    <h1>Login</h1>
    <form class="add-form">
        <div class="form-control">
            <label>Login</label>
            <input type="text" name="text" placeholder="Login" v-model="login"/>
        </div>
        <div class="form-control">
            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Password"
                v-model="password"

            />
        </div>
    </form>
    <button @click="Login" class="btn btn-block">Login</button>
    <div class="separator">or</div>
    <router-link to="/register"><button class="btn-reg btn-block">Register</button></router-link>
    
</template>
<script>
export default {
  data() {
    return {
      login: '',
      password: '',
    }
    },
  methods: {
    async Login(e){
      e.preventDefault();
      let array={
          'name':this.login,
          'password':this.password,
      }
      const res = await fetch('http://127.0.0.1:8000/auth/login',{
        method:'POST',
        headers:{
              'Access-Control-Allow-Origin':'*',
              'Accept': 'application/json',
              'Content-type': 'application/json',
          },
        body: JSON.stringify(array),
      })
      if(res.status==200){
          localStorage.token = await res.text();
          await this.$router.push('/')
      }
      else if(res.status==401){
        alert('wrong name or password')
        console.clear()
      }
      else{
        alert('smth went wrong')
        console.clear()
      } 

    },

}
}
</script>
<style scoped>
a{
    text-decoration: none;
}
h1{
    display: flex;
    align-items: center;
    text-align: center;
}
.add-form {
  margin-bottom: 20px;
}
.form-control {
  margin: 20px 0;
}
.form-control label {
  display: block;
}
.form-control input {
  width: 100%;
  height: 40px;
  margin: 5px;
  padding: 3px 7px;
  font-size: 17px;
}
.form-control-check {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.form-control-check label {
  flex: 1;
}
.form-control-check input {
  flex: 2;
  height: 20px;
}

.separator {
  display: flex;
  align-items: center;
  text-align: center;
    margin-bottom: 20px
}

.separator::before,
.separator::after {
  content: '';
  flex: 1;
  border-bottom: 1px solid #000;
}

.separator:not(:empty)::before {
  margin-right: .25em;
}

.separator:not(:empty)::after {
  margin-left: .25em;
}
</style>