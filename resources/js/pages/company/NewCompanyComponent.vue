<template>
  <div class="w-100 h-100">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Company</h1>
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
                    <label for="name">Company name</label>
                    <input
                      class="form-control"
                      id="name"
                      name="name"
                      type="text"
                      placeholder="Enter company mame"
                      v-model="name"
                      :class="[errorName? 'is-invalid': '']"
                    />

                    <span
                      v-if="errorName"
                      class="error invalid-feedback"
                      id="name-error"
                    >{{errorName}}</span>
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
                    >{{errorEmail}}</span>
                  </div>

                  <div class="form-group">
                    <label for="website">Website</label>
                    <input
                      v-model="website"
                      class="form-control"
                      id="website"
                      type="url"
                      placeholder="Enter company website"
                      :class="[errorWebsite? 'is-invalid': '']"
                    />

                    <span
                      v-if="errorWebsite"
                      class="error invalid-feedback"
                      id="name-error"
                    >{{errorWebsite}}</span>
                  </div>

                  <div class="form-group">
                    <label for="compay-logo">Company Logo</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input
                          @change="fileUploaded"
                          class="custom-file-input"
                          id="compay-logo"
                          type="file"
                          :class="[errorLogo? 'is-invalid': '']"
                        />
                        <label class="custom-file-label" for="compay-logo">{{fileName}}</label>
                      </div>
                    </div>
                    <span
                      v-if="errorLogo"
                      class="error invalid-feedback"
                      id="company-logo-error"
                      :style="{display: errorLogo ? 'block': 'none'}"
                    >{{errorLogo}}</span>
                  </div>

                  <div class="form-group">
                    <button class="btn btn-default" @click="$router.push({name: 'company'})">
                      <i class="fa fa-times" aria-hidden="true"></i>
                      Cancel
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
  data: () => {
    return {
      name: "",
      email: "",
      website: "",
      logo: null,
      fileName: "Choose file",
      errors: {},
    };
  },
  mounted() {},

  computed: {
    errorName() {
      if (!this.errors.name) {
        return false;
      }
      return this.errors.name[0];
    },
    errorEmail() {
      if (!this.errors.email) {
        return false;
      }
      return this.errors.email[0];
    },
    errorWebsite() {
      if (!this.errors.website) {
        return false;
      }
      return this.errors.website[0];
    },
    errorLogo() {
      if (!this.errors.company_logo) {
        return false;
      }
      return this.errors.company_logo[0];
    },
  },

  methods: {
    ...mapActions({
      loadCompanies: "company/loadCompanies",
      addNew: "company/addNewCompany",
    }),
    fileUploaded(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.logo = files[0];
      this.fileName = this.logo.name;
    },
    submit() {
      this.errors = {};
      let data = new FormData();
      data.append("name", this.name);
      if (this.email) {
        data.append("email", this.email);
      }

      if (this.website) {
        data.append("website", this.website);
      }

      if (this.logo) {
        data.append("company_logo", this.logo);
      }

      this.addNew(data)
        .then((response) => {
          EventBus.$emit("ADD_NEW_COMPANY_NOTIFICATION", {
            title: "New Company",
            message: `${this.name} has been added.`,
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
