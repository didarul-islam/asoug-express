<template>
  <!-- form -->
  <validation-observer ref="simpleRules">
    <b-form @submit.prevent="createAttributeValue" enctype="multipart/form-data">
      <b-row>
        <b-col md="6" offset-md="3">
          
          <b-form-group>
            <validation-provider
              #default="{ errors }"
              name="attribute_value"
              rules="required"
            >
              <b-form-input
                v-model="attribute_value"
                :state="errors.length > 0 ? false : null"
                placeholder="Product Attribute Value"
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
  data() {
    const data = {
      attribute_value: null,
      attribute_id: null,
      required
    };

    if(this.incomingValue){
      data.attribute_id = this.incomingValue.attribute_id;
    }
    return data;
  },
  created(){
    console.log("Modal Created");
  },
  props: ['incomingValue', 'handleModal'],
  methods: {

    validationForm() {
      this.$refs.simpleRules.validate().then((success) => {
        if (success) {
        }
      });
    },
    createAttributeValue() {

      console.log(this.incomingValue);
      const formData = {
        attribute_id: this.attribute_id,
        attribute_value: this.attribute_value
      };

      let url = "api/admin/v1/create-attribute-value";
      
      axios.post(
          url, formData
        )
        .then((response) => {
        
          this.$emit('handleModal', response.data.attribute_value, this.attribute_id,"created");
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
              title: "Failed to Add Attribute",
              icon: "EditIcon",
              variant: "warning",
            },
          });
        });
    },
  },
};
</script>
