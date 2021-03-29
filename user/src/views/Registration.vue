<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="card">
          <div class="card-header">
            <h3>Registration</h3>
          </div>
          <div class="card-body">
            <form
              class="row g-3 needs-validation"
              novalidate
              @submit.prevent="registrationHandaler"
            >
              <div class="col-md-8 offset-md-2">
                <input
                  type="text"
                  class="form-control"
                  id="validationCustom01"
                  name="first_name"
                  v-model="first_name"
                  placeholder="First name"
                  required
                />
                <div class="valid-feedback">Looks good!</div>
              </div>
              <div class="col-md-8 offset-md-2">
                <input
                  type="text"
                  class="form-control"
                  id="validationCustom02"
                  name="last_name"
                  v-model="last_name"
                  placeholder="Last name"
                  required
                />
                <div class="valid-feedback">Looks good!</div>
              </div>
              <div class="col-md-8 offset-md-2">
                <div class="input-group has-validation">
                  <input
                    type="text"
                    class="form-control"
                    id="validationCustomUsername"
                    name="email"
                    v-model="email"
                    aria-describedby="inputGroupPrepend"
                    placeholder="Email"
                    required
                  />
                  <div class="invalid-feedback">
                    Please Provide a Valid Email.
                  </div>
                </div>
              </div>
              <div class="col-md-8 offset-md-2">
                <input
                  type="text"
                  class="form-control"
                  id="validationCustom04"
                  name="mobile"
                  v-model="mobile"
                  placeholder="Mobile Number"
                  required
                />
                <div class="invalid-feedback">
                  Please provide a valid Mobile.
                </div>
              </div>
              <div class="col-md-8 offset-md-2">
                <select
                  class="form-select"
                  required
                  aria-label="select example"
                  name="country_id"
                  v-model="country_id"
                >
                  <option selected disabled>Select Country</option>
                  <option value="1">Bangladesh</option>
                  <option value="2">India</option>
                  <option value="3">Japan</option>
                </select>
                <div class="invalid-feedback">
                  Example invalid select feedback
                </div>
              </div>

              <div class="col-md-8 offset-md-2">
                <input
                  type="password"
                  class="form-control"
                  id="validationCustom05"
                  name="password"
                  v-model="password"
                  placeholder="Password"
                  required
                />
                <div class="invalid-feedback">
                  Please provide a valid Mobile.
                </div>
              </div>
              <div class="col-md-8 offset-md-2">
                <input
                  type="password"
                  class="form-control"
                  id="validationCustom06"
                  name="password_confirmation"
                  v-model="password_confirmation"
                  placeholder="Confirme Password"
                  required
                />
                <div class="invalid-feedback">
                  Please provide a valid Mobile.
                </div>
              </div>
              <div class="col-md-8 offset-md-2">
                <button class="btn btn-primary" type="submit">
                  Submit form
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<script>
import axios from "axios";

export default {
  name: "Home",
  data() {
    return {
      first_name: " ",
      last_name: "",
      mobile: "",
      email: "",
      password: "",
      password_confirmation: "",
      country_id: "",
    };
  },

  methods: {
    registrationHandaler: function () {

      let my_data = {
          first_name: this.first_name,
          last_name: this.last_name,
          mobile: this.mobile,
          email: this.email,
          country_id: this.country_id,
          password: this.password,
          password_confirmation: this.password_confirmation,
      };

      var url = "http://localhost:8000/api/auth/register";
      axios
        .post(url, my_data)
        .then(function (response) {
          console.log(response.data);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>

