<template>
  <tr>
    <td>{{ company.id }}</td>
    <td>
      <img :src="company.logo" style="max-width: 50px; max-height: 50px" />
    </td>
    <td>{{ company.name }}</td>
    <td>{{ company.email }}</td>
    <td>
      <a :href="company.website">{{ company.website }}</a>
    </td>
    <td class="d-flax">
      <a class="btn btn-primary btn-sm" @click.prevent="newEmployee">
        <i class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;New employee
      </a>

      <a class="btn btn-primary btn-sm" @click.prevent="view">
        <i class="fa fa-eye" aria-hidden="true"></i> &nbsp;View
      </a>
      <a class="btn btn-info btn-sm" @click.prevent="edit">
        <i class="fa fa-edit" aria-hidden="true"></i> &nbsp;Edit
      </a>
      <a class="btn btn-danger btn-sm" @click.prevent="deleteCompany">
        <i class="fa fa-trash" aria-hidden="true"></i> &nbsp; Delete
      </a>
    </td>
  </tr>
</template>

<script>
import EventBus from "../../event-bus";
import { mapActions } from "vuex";

export default {
  props: ["company"],
  mounted() {},
  methods: {
    ...mapActions({
      delete: "company/deleteCompany",
    }),
    deleteCompany() {
      var r = confirm(`Are you sure you want to delete ${this.company.name}?`);
      if (r == true) {
        this.delete(this.company.id)
          .then((response) => {
            EventBus.$emit("DELETE_COMPANY_NOTIFICATION", {
              title: "Delete Company",
              message: `${this.company.name} has been deleted.`,
              type: "alert-success",
            });
          })
          .catch((err) => {});
      }
    },

    edit() {
      this.$router.push({
        name: "editCompany",
        params: { id: this.company.id },
      });
    },

    view() {
      this.$router.push({
        name: "viewCompany",
        params: { id: this.company.id },
      });
    },
    newEmployee() {
      this.$router.push({
        name: "addNewEmployee",
        params: { companyId: this.company.id },
      });
    },
  },
};
</script>
