<template>
  <!-- form -->
  <div class="card">
    <div class="card-header"><h3 class="mt-1">Edit Country</h3></div>
    <hr />
    <div class="card-body">
      <validation-observer ref="simpleRules">
        <b-form @submit.prevent="categoryUpdate" enctype="multipart/form-data">
          <b-row>
            <b-col md="6" offset-md="3">
              <b-form-group>
                <validation-provider
                  #default="{ errors }"
                  name="name"
                  rules="required"
                >
                  <b-form-input
                    v-model="name"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Country Name"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <b-col md="6" offset-md="3">
              <b-form-group>
                <validation-provider
                  #default="{ errors }"
                  name="arabic_name"
                  rules="required"
                >
                  <b-form-input
                    v-model="arabic_name"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Arabic Name"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <b-col md="6" offset-md="3">
              <b-button variant="primary" type="submit" @click="validationForm">
                Submit
              </b-button>
            </b-col>
          </b-row>
        </b-form>
      </validation-observer>
    </div>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import {
  BFormInput,
  BFormGroup,
  BForm,
  BRow,
  BCol,
  BButton,
  BCardText,
  BFormFile,
  BFormSelect,
} from "bootstrap-vue";
import { required, email } from "@validations";
import axios from "axios";
import ToastificationContent from "@core/components/toastification/ToastificationContent";

export default {
  components: {
    ValidationProvider,
    ValidationObserver,
    BCardText,
    BFormInput,
    BFormGroup,
    BForm,
    BRow,
    BCol,
    BButton,
    BFormFile,
    BFormSelect,
  },
  data() {
    return {
      name: "",
      arabic_name: "",
      required,
    };
  },
  mounted() {
    this.getData();
  },

  methods: {
    validationForm() {
      this.$refs.simpleRules.validate().then((success) => {
        if (success) {
        }
      });
    },
    getData() {
      this.$http
        .get(`admin/v1/country/${this.$route.params.id}`)
        .then((res) => {
          console.log(res.data);

          // Changed Some Code
          this.name = res.data.country.name;
          this.arabic_name = res.data.country.arabic_name;
        })
        .catch((error) => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Something Wrong",
              icon: "EditIcon",
              variant: "error",
            },
          });
        });
    },

    categoryUpdate() {
      const formData = new FormData();
      formData.append("name", this.name);
      formData.append("arabic_name", this.arabic_name);
      this.$http
        .post(`admin/v1/update-country/${this.$route.params.id}`, formData)
        .then((response) => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Country Updated",
              icon: "EditIcon",
              variant: "success",
            },
          });
          this.$router.push("/country");
        })
        .catch((error) => {
          console.log(error);
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Country Updated Failed",
              icon: "EditIcon",
              variant: "warning",
            },
          });
        });
    },
  },
};
</script>
