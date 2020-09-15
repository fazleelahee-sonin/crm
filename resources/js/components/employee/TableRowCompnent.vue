<template>
  <tr>
    <td>{{ employee.id }}</td>
    <td>{{ employee.first_name }}</td>
    <td>{{ employee.last_name }}</td>
    <td>{{ employee.company.name }}</td>
    <td>
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
  props: ["employee"],
  mounted() {},
  methods: {
    ...mapActions({
      delete: "employee/deleteEmployee",
    }),
    deleteCompany() {
      var r = confirm(
        `Are you sure you want to delete ${this.employee.first_name} ${this.employee.last_name}?`
      );
      if (r == true) {
        this.delete(this.employee.id)
          .then((response) => {
            EventBus.$emit("DELETE_EMPLOYEE_NOTIFICATION", {
              title: "Delete Employee",
              message: `${this.employee.first_name} ${this.employee.last_name} has been deleted.`,
              type: "alert-success",
            });
          })
          .catch((err) => {});
      }
    },

    edit() {
      this.$router.push({
        name: "editEmployee",
        params: { id: this.employee.id },
      });
    },

    view() {
      this.$router.push({
        name: "viewEmployee",
        params: { id: this.employee.id },
      });
    },
  },
};
</script>
