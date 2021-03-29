<template>
  <div>
    <form @submit.prevent="userLogin">
        <div class="form-group">
            <label for="title">Email</label>
            <input
            type="text"
            class="form-control"
            id="email"
            required
            v-model="email"
            name="email"
            />
        </div>
        <div class="form-group">
            <label for="title">Password</label>
            <input
            type="password"
            class="form-control"
            id="password"
            required
            v-model="password"
            name="password"
            />
        </div>
        <div v-if="validationError" class="alert alert-danger" role="alert">
            {{ validationError }}
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>
</template>


<script>

  import axios from "axios";
  import {Host} from '../config/config';

  
  export default {
      
    data() {
      return {
       email: "",
       password: "",
       validationError: ""
      }
    },
    methods: {
      userLogin() {
            axios
                .post(Host+"/auth/login", {
                    email: this.email,
                    password: this.password
                })
                .then(response => {

                    console.log(response.data);
                    
                    localStorage.setItem("token", response.data.access_token);
                    axios.defaults.headers.common["Authorization"] = "Bearer " + response.data.access_token;
                    if(parseInt(response.data.user.role) === 2){
                        this.$router.push("/vendor-dashboard");
                    }else if(parseInt(response.data.user.role) == 3){
                        this.$router.push("/customer-dashboard");
                    }else{
                        localStorage.removeItem("token");
                        this.$router.push("/error-404");
                    }

                })
                .catch(error => {
                    if (error.response) {
                        this.validationError = error.response.data;
                    }
                    localStorage.removeItem("token");
                    
                });
        }
    }
  }
</script>