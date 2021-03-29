<template>
  <!-- form -->
  <validation-observer ref="simpleRules">
    <b-form @submit.prevent="createAttribute" enctype="multipart/form-data">
      <b-row>
        <b-col md="6" offset-md="3">
          
          <b-form-group>
            <validation-provider
              #default="{ errors }"
              name="attribute"
              rules="required"
            >
              <b-form-input
                v-model="attribute"
                :state="errors.length > 0 ? false : null"
                placeholder="Product Attribute Name"
              />
              <small class="text-danger">{{ errors[0] }}</small>
            </validation-provider>
          </b-form-group>
        </b-col>

        <b-col md="6" offset-md="3" class="text-center">
          <b-button variant="primary" type="submit" @click="validationForm">
            Submit
          </b-button>
        </b-col>
      </b-row>
    </b-form>
  </validation-observer>
</template>

<script>
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import {
  BFormInput,
  BFormGroup,
  BForm,
  BRow,
  BCol,
  BButton,
  BCardText,
} from "bootstrap-vue";
import { required, email } from "@validations";
import axios from "axios";
import { BFormFile } from "bootstrap-vue";
import { BFormSelect } from "bootstrap-vue";
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
  props: ['incomingAttr', 'handleModal'],
  data() {
    const data = {
      id: null,
      attribute: null,
      required
    };

    if(this.incomingAttr){
      data.id = this.incomingAttr.id;
      data.attribute = this.incomingAttr.attribute;
    }

    return data;

  },
  created(){
    console.log("Modal Created");
  },
  methods: {

    validationForm() {
      this.$refs.simpleRules.validate().then((success) => {
        if (success) {
        }
      });
    },
    createAttribute() {

      const formData = {
        attribute: this.attribute
      };

      let url = "api/admin/v1/create-attribute";
      let status = 'created';
      if(this.incomingAttr){
        url = "api/admin/v1/update-attribute";
        formData.id = this.incomingAttr.id;
        status = 'updated';
      }
      
      axios.post(
          url, formData
        )
        .then((response) => {
          
          console.log(response.data);
          
          this.$emit('handleModal', response.data.attribute, status);
          this.$toast({
            component: ToastificationContent,
            props: {
              title: response.data.message,
              icon: "EditIcon",
              variant: "success",
            },
          });

          
          // this.$router.push("/variations");
        
        })
        .catch((error) => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Failed to Modify Attribute",
              icon: "EditIcon",
              variant: "warning",
            },
          });
        });
    },
  },
};
</script>
