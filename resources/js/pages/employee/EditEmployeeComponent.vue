<template>
  <div class="w-100 h-100">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Employee</h1>
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
                    <label for="first_name">First Name</label>
                    <input
                      class="form-control"
                      id="first-name"
                      name="first_name"
                      type="text"
                      placeholder="Enter first name"
                      v-model="firstName"
                      :class="[
                                                errorFirstName ? 'is-invalid' : ''
                                            ]"
                    />

                    <span
                      v-if="errorFirstName"
                      class="error invalid-feedback"
                      id="first-name-error"
                    >{{ errorFirstName }}</span>
                  </div>

                  <div class="form-group">
                    <label for="last-name">Last name</label>
                    <input
                      class="form-control"
                      id="last-name"
                      name="last-name"
                      type="text"
                      placeholder="Enter last name"
                      v-model="lastName"
                      :class="[
                                                errorLastName ? 'is-invalid' : ''
                                            ]"
                    />

                    <span
                      v-if="errorLastName"
                      class="error invalid-feedback"
                      id="last-name-error"
                    >{{ errorLastName }}</span>
                  </div>

                  <div class="form-group">
                    <label for="company-name">Company Name</label>
                    <input
                      class="form-control"
                      id="company-name"
                      name="company-name"
                      type="text"
                      v-model="company.name"
                      disabled
                    />
                  </div>

                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input
                      v-model="email"
                      class="form-control"
                      id="email"
                      type="email"
                      placeholder="Enter email"
                      :class="[
                                                errorEmail ? 'is-invalid' : ''
                                            ]"
                    />
                    <span
                      v-if="errorEmail"
                      class="error invalid-feedback"
                      id="email-error"
                    >{{ errorEmail }}</span>
                  </div>

                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input
                      v-model="phone"
                      class="form-control"
                      id="phone"
                      placeholder="Enter company website"
                      :class="[
                                                errorPhone ? 'is-invalid' : ''
                                            ]"
                    />

                    <span
                      v-if="errorPhone"
                      class="error invalid-feedback"
                      id="phone-error"
                    >{{ errorPhone }}</span>
                  </div>

                  <div class="form-group">
                    <button
                      class="btn btn-default"
                      @click="
                                                $router.push({
                                                    name: 'employee'
                                                })
                                            "
                    >
                      <i class="fa fa-times" aria-hidden="true"></i>Cancel
                    </button>
                    <button class="btn btn-primary" type="submit">
                      <i class="fa fa-save" aria-hidden="true"></i>Update
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
  props: ["id"],
  data: () => {
    return {
      company: {},
      firstName: "",
      lastName: "",
      email: "",
      phone: "",
      errors: {},
    };
  },
  created() {
    this.load(this.id)
      .then((response) => {
        this.firstName = response.data.first_name;
        this.lastName = response.data.last_name;
        this.email = response.data.email;
        this.company = response.data.company;
        this.phone = response.data.phone;
      })
      .catch((err) => {
        console.log(err);
      });
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
      load: "employee/editEmployee",
      update: "employee/updateEmployee",
    }),

    submit() {
      this.errors = {};
      let data = {
        id: this.id,
        formData: new FormData(),
      };

      data.formData.append("_method", "put");
      data.formData.append("first_name", this.firstName);
      data.formData.append("last_name", this.lastName);
      data.formData.append("company_id", this.company.id);
      if (this.email) {
        data.formData.append("email", this.email);
      }

      if (this.phone) {
        data.formData.append("phone", this.phone);
      }

      this.update(data)
        .then((response) => {
          EventBus.$emit("UPDATE_EMPLOYEE_NOTIFICATION", {
            title: "Update",
            message: `${this.firstName} ${this.lastName} has been added.`,
            type: "alert-success",
          });
          this.$router.push({ name: "employee" });
        })

        .catch((err) => {
          this.errors = err.response.data.errors;
        });
    },
  },
};
</script>
