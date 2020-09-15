<template>
  <div class="w-100 h-100">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View Employee</h1>
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
                <form class="col-12" novalidate>
                  <div class="form-group">
                    <label for="first-name">First name</label>
                    <input
                      class="form-control"
                      id="first-name"
                      name="first_name"
                      type="text"
                      placeholder="Enter first mame"
                      v-model="firstName"
                      disabled
                    />
                  </div>

                  <div class="form-group">
                    <label for="last-name">Last name</label>
                    <input
                      class="form-control"
                      id="last-name"
                      name="last_name"
                      type="text"
                      placeholder="Enter last mame"
                      v-model="lastName"
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
                      placeholder
                      disabled
                    />
                  </div>

                  <div class="form-group">
                    <label for="email">Company Name</label>
                    <input
                      v-model="company.name"
                      class="form-control"
                      id="company"
                      type="text"
                      placeholder
                      disabled
                    />
                  </div>

                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input
                      v-model="phone"
                      class="form-control"
                      id="phone"
                      type="text"
                      placeholder
                      disabled
                    />
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
                    <button class="btn btn-primary" @click="edit">
                      <i class="fa fa-edit" aria-hidden="true"></i>Edit
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

  methods: {
    ...mapActions({
      load: "employee/editEmployee",
    }),
    edit() {
      this.$router.replace({
        name: "editEmployee",
        params: { id: this.id },
      });
    },
  },
};
</script>
