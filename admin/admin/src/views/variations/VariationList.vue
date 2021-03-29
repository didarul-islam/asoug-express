<template>
  <section>
    
    <div class="d-flex justify-content-end">
      <b-button variant="primary" class="my-2" @click="() => hanldeAttributeModal(null, null)">Create Attribute</b-button>
    </div>

    <div>
      <!-- search input -->
      <div class="custom-search d-flex justify-content-end">
        <b-form-group>
          <div class="d-flex align-items-center">
            <label class="mr-1">Search</label>
            <b-form-input
              v-model="searchTerm"
              placeholder="Search"
              type="text"
              class="d-inline-block"
            />
          </div>
        </b-form-group>
      </div>

      <!-- table -->
      <vue-good-table
        :columns="columns"
        :rows="rows"
        :rtl="direction"
        :search-options="{
          enabled: true,
          externalQuery: searchTerm,
        }"
        :select-options="{
          enabled: true,
          selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
          selectionInfoClass: 'custom-class',
          selectionText: 'rows selected',
          clearSelectionText: 'clear',
          disableSelectInfo: true, // disable the select info panel on top
          selectAllByGroup: true, // when used in combination with a grouped table, add a checkbox in the header row to check/uncheck the entire group
        }"
        :pagination-options="{
          enabled: true,
          perPage: pageLength,
        }"
      >
        <template slot="table-row" slot-scope="props">
          <!-- Column: Attribute -->
          <span v-if="props.column.field === 'attribute'" class="text-nowrap">
            <span class="text-nowrap">{{ props.row.attribute }}</span>
          </span>
          
          <!-- Column: Attribute Values -->
          <span v-else-if="props.column.field === 'values'" class="text-nowrap">
            <div class="d-flex justify-content-between">
              <div>
                <b-badge variant="secondary" v-for="attrval in props.row.values" :key="attrval.id" class="text-nowrap mr-1">
                  {{ attrval.value }}
                </b-badge>
              </div>
              <b-badge @click="() => hanldeAttributeValueModal(null, props.row.id, null)" class="d-inline-block cursor-pointer" variant="danger">Add Value</b-badge>
            </div>
          </span>

          <!-- Column: Action -->
          <span v-else-if="props.column.field === 'action'">
            <span>
              <b-dropdown
                variant="link"
                toggle-class="text-decoration-none"
                no-caret
              >
                <template v-slot:button-content>
                  <feather-icon
                    icon="MoreVerticalIcon"
                    size="16"
                    class="text-body align-middle mr-25"
                  />
                </template>
                <b-dropdown-item>
                  <a href="" @click.prevent="() => hanldeAttributeModal(props.row, null)">
                    <feather-icon icon="Edit2Icon" class="mr-50" />
                    <span>Edit</span></a>
                </b-dropdown-item>
                <b-dropdown-item>
                  <a href="" @click.prevent="deleteData(props.row.id)">
                    <feather-icon icon="TrashIcon" class="mr-50" />
                    <span> Delete </span>
                  </a>
                </b-dropdown-item>
              </b-dropdown>
            </span>
          </span>

          <!-- Column: Common -->
          <span v-else>
            {{ props.formattedRow[props.column.field] }}
          </span>
        </template>

        <!-- pagination -->
        <template slot="pagination-bottom" slot-scope="props">
          <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-center mb-0 mt-1">
              <span class="text-nowrap"> Showing 1 to </span>
              <b-form-select
                v-model="pageLength"
                :options="['3', '5', '10']"
                class="mx-1"
                @input="
                  (value) => props.perPageChanged({ currentPerPage: value })
                "
              />
              <span class="text-nowrap"> of {{ props.total }} entries </span>
            </div>
            <div>
              <b-pagination
                :value="1"
                :total-rows="props.total"
                :per-page="pageLength"
                first-number
                last-number
                align="right"
                prev-class="prev-item"
                next-class="next-item"
                class="mt-1 mb-0"
                @input="(value) => props.pageChanged({ currentPage: value })"
              >
                <template #prev-text>
                  <feather-icon icon="ChevronLeftIcon" size="18" />
                </template>
                <template #next-text>
                  <feather-icon icon="ChevronRightIcon" size="18" />
                </template>
              </b-pagination>
            </div>
          </div>
        </template>
      </vue-good-table>
    </div>
    
    <b-modal id="attribute-modal" hide-footer>
      <attribute-modal @handleModal="hanldeAttributeModal" :incomingAttr="attribute" ></attribute-modal>
    </b-modal>

    <b-modal id="attribute-value-modal" hide-footer>
      <attribute-value-modal @handleModal="hanldeAttributeValueModal" :incomingValue="attrValue"></attribute-value-modal>
    </b-modal>

  </section>
</template>

<script>

import { ValidationProvider, ValidationObserver } from "vee-validate";
import axios from "axios";
import {
  BAvatar,
  BBadge,
  BPagination,
  BFormGroup,
  BFormInput,
  BFormSelect,
  BForm,
  BRow,
  BCol,
  BButton,
  BDropdown,
  BDropdownItem,
} from "bootstrap-vue";
import { required, email } from "@validations";
import { VueGoodTable } from "vue-good-table";
import "vue-good-table/dist/vue-good-table.css";
import store from "@/store/index";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import AttributeModal from './AttributeModal.vue';
import AttributeValueModal from './AttributeValueModal';

export default {
  components: {
    VueGoodTable,
    BAvatar,
    BBadge,
    BPagination,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BDropdown,
    BDropdownItem,
    BForm,
    BRow,
    BCol,
    BButton,
    ValidationProvider,
    ValidationObserver,
    AttributeModal,
    AttributeValueModal
  },
  data() {
    return {
      pageLength: 3,
      dir: false,
      attribute: null,
      attrValue: null,
      columns: [
        {
          label: "Variation Name",
          field: "attribute",
        },
        {
          label: "Variation Values",
          field: "values",
        },
        {
          label: "Action",
          field: "action",
        },
      ],
      rows: [],
      searchTerm: "",
      status: [
        {
          1: "Current",
          2: "Professional",
          3: "Rejected",
          4: "Resigned",
          5: "Applied",
        },
        {
          1: "light-primary",
          2: "light-success",
          3: "light-danger",
          4: "light-warning",
          5: "light-info",
        },
      ],
    };
  },
  computed: {
    statusVariant() {
      const statusColor = {
        /* eslint-disable key-spacing */
        Current: "light-primary",
        Professional: "light-success",
        Rejected: "light-danger",
        Resigned: "light-warning",
        Applied: "light-info",
        /* eslint-enable key-spacing */
      };
      return (status) => statusColor[status];
    },
    direction() {
      if (store.state.appConfig.isRTL) {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.dir = true;
        return this.dir;
      }
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.dir = false;
      return this.dir;
    },
  },
  created() {
    this.fetchVariations();
  },
  methods: {
    // Attribute is used for row collection so that we can perform operation on that row
    // and status is used to notify that an operation was successful
    hanldeAttributeModal(attribute, status){
      
      this.attribute = attribute;
      this.$bvModal.show('attribute-modal');
      
      if(attribute && status){
        this.$bvModal.hide('attribute-modal');
        
        if(status === "created"){
          this.rows.push({
            id: attribute.id,
            attribute: attribute.name,
            values: attribute.values
          });
        }else{
          const rows = this.rows;
          rows.forEach(row => {
            if(row.id === attribute.id){
              row.id = attribute.id;
              row.attribute = attribute.name;
              row.values = attribute.values;
            }
          });
          this.rows = rows;
        }

      }

    },
    hanldeAttributeValueModal(attrValue, attrId, status){
      
      this.attrValue = {
        attribute_id: attrId
      };

      this.$bvModal.show('attribute-value-modal');
      
      if(attrValue && status){
        this.$bvModal.hide('attribute-value-modal');
        
        if(status === "created"){
          this.rows.forEach(row => {
            if(row.id === attrId){
              row.values.push(attrValue);
            }
          });
          if(row.values.length === 0){
            row.values.push(attrValue);
          }
        }
        // else{
        //   const rows = this.rows;
        //   rows.forEach(row => {
        //     if(row.id === attribute.id){
        //       row.id = attribute.id;
        //       row.attribute = attribute.name;
        //       row.values = attribute.values;
        //     }
        //   });
        //   this.rows = rows;
        // }

      }

    },
    validationForm() {
      this.$refs.simpleRules.validate().then((success) => {
        if (success) {
        }
      });
    },
    fetchVariations() {
      this.$http.get("admin/v1/variations").then((res) => {
        
        console.log(res.data);

        const rows = [];
        res.data.forEach(element => {
          rows.push({
            id: element.id,
            attribute: element.name,
            values: element.values
          });
        });

        this.rows = rows;
      });
    },
    deleteData(id) {
      // eslint-disable-next-line no-undef
      this.$bvModal
        .msgBoxConfirm("Please confirm that you want to delete everything.", {
          title: "Please Confirm",
          size: "sm",
          okVariant: "primary",
          okTitle: "Yes",
          cancelTitle: "No",
          cancelVariant: "outline-secondary",
          hideHeaderClose: false,
          centered: true,
        })
        .then((value) => {
          if (value) {
            this.$http
              .delete(`admin/v1/delete-attribute/${id}`)
              .then((res) => {
                
                const rows = this.rows.filter(row => row.id !== id);
                this.rows = rows;

                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: "Attribute Deleted",
                    icon: "EditIcon",
                    variant: "success",
                  },
                });

              })
              .catch((error) => {
                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: "Something Wrong",
                    icon: "EditIcon",
                    variant: "eror",
                  },
                });
              });
          }
        });
    },
  },
};
</script>

<style scoped>
  .cursor-pointer{
    pointer: 'cursor';  
  }
</style>