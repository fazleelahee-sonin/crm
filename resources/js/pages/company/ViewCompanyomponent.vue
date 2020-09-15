<template>
  <div class="w-100 h-100">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View Company</h1>
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
                    <label for="name">Company name</label>
                    <input
                      class="form-control"
                      id="name"
                      name="name"
                      type="text"
                      placeholder="Enter company mame"
                      v-model="name"
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
                    <label for="website">Website</label>
                    <input
                      v-model="website"
                      class="form-control"
                      id="website"
                      type="url"
                      placeholder
                      disabled
                    />
                  </div>

                  <div class="form-group">
                    <label for="compay-logo">Company Logo</label>
                    <div class="w-100 mb-2" v-if="logoUrl">
                      <img :src="logoUrl" style="max-width: 100px; max-height: 100px" />
                    </div>
                  </div>

                  <div class="form-group">
                    <button
                      class="btn btn-default"
                      @click="
                                                $router.push({
                                                    name: 'company'
                                                })
                                            "
                    >
                      <i class="fa fa-times" aria-hidden="true"></i>Cancel
                    </button>
                    <button class="btn btn-info" @click="addEmployee">
                      <i class="fa fa-user-plus" aria-hidden="true"></i>Add Employee
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
      name: "",
      email: "",
      website: "",
      logo: null,
      logoUrl: "",
      fileName: "Choose new logo",
      errors: {},
    };
  },
  created() {
    this.load(this.id)
      .then((response) => {
        this.name = response.data.name;
        this.email = response.data.email;
        this.website = response.data.website;
        this.logoUrl = response.data.logo || `//via.placeholder.com/100`;
      })
      .catch((err) => {
        console.log(err);
      });
  },
  mounted() {},

  methods: {
    ...mapActions({
      load: "company/editCompany",
    }),
    edit() {
      this.$router.replace({
        name: "editCompany",
        params: { id: this.id },
      });
    },
    addEmployee() {
      this.$router.push({
        name: "addNewEmployee",
        params: { companyId: this.id },
      });
    },
  },
};
</script>
