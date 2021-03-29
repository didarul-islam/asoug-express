<template>
  <!-- form -->
  <div class="card">
    <div class="card-header"><h3 class="mt-1">Edit Currency</h3></div>
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
                    placeholder="Currency Name"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <b-col md="6" offset-md="3">
              <b-form-group>
                <validation-provider
                  #default="{ errors }"
                  name="symbol"
                  rules="required"
                >
                  <b-form-input
                    v-model="symbol"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Symbol"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <b-col md="6" offset-md="3">
              <b-form-group>
                <validation-provider
                  #default="{ errors }"
                  name="code"
                  rules="required"
                >
                  <b-form-input
                    v-model="code"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Code"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <b-col md="6" offset-md="3">
              <b-form-group>
                <validation-provider
                  #default="{ errors }"
                  name="exchange_rate"
                  rules="required"
                >
                  <b-form-input
                    v-model="exchange_rate"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Exchange Rate"
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
      symbol: "",
      code: "",
      exchange_rate: "",
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
        .get(`admin/v1/currency/${this.$route.params.id}`)
        .then((res) => {
          console.log(res.data);

          // Changed Some Code
          this.name = res.data.currency.name;
          this.symbol = res.data.currency.symbol;
          this.code = res.data.currency.code;
          this.exchange_rate = res.data.currency.exchange_rate;
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
      var formData = new FormData();
      formData.append("name", this.name);
      formData.append("symbol", this.symbol);
      formData.append("code", this.code);
      formData.append("exchange_rate", this.exchange_rate);
      this.$http
        .post(`admin/v1/update-currency/${this.$route.params.id}`, formData)
        .then((response) => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Currency Updated",
              icon: "EditIcon",
              variant: "success",
            },
          });
          this.$router.push("/currency");
        })
        .catch((error) => {
          console.log(error);
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Currency Updated Failed",
              icon: "EditIcon",
              variant: "warning",
            },
          });
        });
    },
  },
};
</script>
