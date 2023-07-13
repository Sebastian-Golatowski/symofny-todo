<script setup>
    import Button from '../components/Button.vue';
</script>

<template>
    <h1>Register</h1>
    <form class="add-form">
        <div class="form-control">
            <label>Login</label>
            <input type="text" name="text" placeholder="Login" v-model="login" required="true"/>
        </div>
        <div class="form-control">
            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Password"
                v-model="password"
                required="true"
            />
        </div>
        <div class="form-control">
            <label>Confirm Password</label>
            <input
                type="co-password"
                name="password"
                placeholder="Confirm Password"
                v-model="CoPassword"
            />
        </div>
    </form>
    <button class="btn btn-block"  @click="Submit">Register</button>
    <div class="separator">or</div>
    <router-link to="/login"><button class="btn-reg btn-block">Login</button></router-link>
    
</template>

<script>
export default {
  data() {
    return {
      login:'',
      password: '',
      CoPassword:''
    }
    },
  methods:{
    async Submit(e){
      e.preventDefault();
      if(this.password == this.CoPassword){
        let array={
        'name':this.login,
        'password':this.password,
        'coPassword':this.CoPassword
        }
          
        const res = await fetch("http://localhost:8000/auth/register",{
          method:'PUT',
          headers:{
              'Accept': 'application/json',
              'Content-type': 'application/json',
          },
          body: JSON.stringify(array),
        })
        if(res.status==201){
          localStorage.token = await res.text();
          await this.$router.push('/') // here is the problem, maybe?
        }
        else{
          alert('name is allready in use')
          console.clear()
          this.login='',
          this.password= '',
          this.CoPassword=''
        } 
      }
      else{
        alert('passwords are not the same')
        console.clear()
        this.login='',
        this.password= '',
        this.CoPassword=''
      }
      
      
    }
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