<template>
  <div class="w-100 h-100">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Employee</h1>
          </div>
          <div class="col-sm-6">
            <div class="float-sm-right"></div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="p-3 mb-3">
              <!-- /.row -->
              <!-- Form-->
              <div class="row">
                <form class="col-12" action="#" @submit.prevent="submit" novalidate>
                  <div class="form-group">
                    <label for="first-name">Employee first name</label>
                    <input
                      class="form-control"
                      id="first-name"
                      name="first_name"
                      type="text"
                      placeholder="Enter first name"
                      v-model="firstName"
                      :class="[errorFirstName? 'is-invalid': '']"
                    />

                    <span
                      v-if="errorFirstName"
                      class="error invalid-feedback"
                      id="first-name-error"
                      v-html="errorFirstName"
                    ></span>
                  </div>

                  <div class="form-group">
                    <label for="last-name">Employee last name</label>
                    <input
                      class="form-control"
                      id="last-name"
                      name="last_name"
                      type="text"
                      placeholder="Enter last name"
                      v-model="lastName"
                      :class="[errorLastName? 'is-invalid': '']"
                    />

                    <span
                      v-if="errorLastName"
                      class="error invalid-feedback"
                      id="last-name-error"
                      v-html="errorLastName"
                    ></span>
                  </div>

                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input
                      v-model="email"
                      class="form-control"
                      id="email"
                      type="email"
                      placeholder="Enter email"
                      :class="[errorEmail? 'is-invalid': '']"
                    />
                    <span
                      v-if="errorEmail"
                      class="error invalid-feedback"
                      id="name-error"
                      v-html="errorEmail"
                    ></span>
                  </div>

                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input
                      v-model="phone"
                      class="form-control"
                      id="phone"
                      type="text"
                      placeholder="Enter phone number"
                      :class="[errorPhone? 'is-invalid': '']"
                    />

                    <span
                      v-if="errorPhone"
                      class="error invalid-feedback"
                      id="phone-error"
                      v-html="errorPhone"
                    ></span>
                  </div>

                  <div class="form-group">
                    <button class="btn btn-default" @click="$router.push({name: 'company'})">
                      <i class="fa fa-times" aria-hidden="true"></i>Cancel
                    </button>
                    <button class="btn btn-primary" type="submit">
                      <i class="fa fa-save" aria-hidden="true"></i>
                      Save
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ./container-fluid -->
    </section>
  </div>
</template>

<script>
import EventBus from "../../event-bus";
import { mapActions } from "vuex";

export default {
  props: ["companyId"],
  data: () => {
    return {
      firstName: "",
      lastName: "",
      email: "",
      phone: "",
      errors: {},
    };
  },
  mounted() {},

  computed: {
    errorFirstName() {
      if (!this.errors.first_name) {
        return false;
      }
      return this.errors.first_name.join("<br />");
    },
    errorLastName() {
      if (!this.errors.first_last) {
        return false;
      }
      return this.errors.last_name.join("<br />");
    },
    errorEmail() {
      if (!this.errors.email) {
        return false;
      }
      return this.errors.email.join("<br />");
    },
    errorPhone() {
      if (!this.errors.phone) {
        return false;
      }
      return this.errors.phone.join("<br />");
    },
  },

  methods: {
    ...mapActions({
      loadCompanies: "employee/loadCompanies",
      addNew: "employee/addNewEmployee",
    }),
    submit() {
      this.errors = {};
      let data = new FormData();
      data.append("first_name", this.firstName);
      data.append("last_name", this.lastName);
      data.append("company_id", this.companyId);

      if (this.email) {
        data.append("email", this.email);
      }

      if (this.phone) {
        data.append("phone", this.phone);
      }

      this.addNew(data)
        .then((response) => {
          EventBus.$emit("ADD_NEW_EMPOYEE_NOTIFICATION", {
            title: "New Employee",
            message: `${this.firstName} ${this.lastName} has been added.`,
            type: "alert-success",
          });
          this.$router.push({ name: "company" });
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
        });
    },
  },
};
</script>
