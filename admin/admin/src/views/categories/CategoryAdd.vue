<template>
  <div class="card">
    <div class="card-header"><h3 class="mt-1">Add Category</h3></div>
    <hr>
    <div class="card-body">
      <validation-observer ref="simpleRules">
        <b-form @submit.prevent="categoryAdd" enctype="multipart/form-data">
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
                    placeholder="Category Name"
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
              <b-form-group>
                <validation-provider
                  #default="{ errors }"
                  rules="required|integer"
                  name="commision"
              
                >
                  <b-form-input
                    v-model="commision"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Commision"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <b-col md="6" offset-md="3">
              <b-form-select
                name="parent_id"
                v-model="CategoryAlls"
                id="CategoryAll"
                :options="CategoryAllOptions"
              >
                <template v-slot:first>
                  <option value="0">- Make Parent -</option>
                </template>
              </b-form-select>
            </b-col>

            <b-col md="6" offset-md="3" class="my-2">
              <b-form-file
                v-model="image"
                name="image"
                placeholder="Choose a file or drop it here..."
                drop-placeholder="Drop file here..."
              />
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
    return {
      image: [],
      name: "",
      arabic_name: "",
      commision: "",
      parent_id: "",
      required,
      CategoryAlls: [],
      CategoryAllOptions: [],
    };
  },
  created() {
    this.setCategoryData();
  },

  methods: {
    onFileChange(event) {
      this.image = event.target.files[0];
      console.log(event.target.files[0]);
    },
    setCategoryData: function () {
      axios
        .get("api/admin/v1/category")
        .then((resp) => {
          console.log(resp.data);
          this.CategoryAlls = resp.data.CategoryAll;
          for (var i = 0; i < this.CategoryAlls.length; i++) {
            var option = [];
            for (var key in this.CategoryAlls[i]) {
              if (key == "id") {
                option["value"] = this.CategoryAlls[i][key];
              } else if (key == "name") {
                option["text"] = this.CategoryAlls[i][key];
              }
            }
            this.CategoryAllOptions.push(Object.assign({}, option));
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    validationForm() {
      this.$refs.simpleRules.validate().then((success) => {
        if (success) {
        }
      });
    },

    categoryAdd() {
      var formData = new FormData();
      formData.append("photo", this.image);
      formData.append("name", this.name);
      formData.append("arabic_name", this.arabic_name);
      formData.append("commision", this.commision);
      formData.append("parent_id", this.CategoryAlls);

      axios
        .post("api/admin/v1/category", formData)
        .then((response) => {
          console.log(response.data);
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Category Added",
              icon: "EditIcon",
              variant: "success",
            },
          });
          this.$router.push("/category");
        })
        .catch((error) => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Category Added Failed",
              icon: "EditIcon",
              variant: "warning",
            },
          });
        });
    },
  },
};
</script>

