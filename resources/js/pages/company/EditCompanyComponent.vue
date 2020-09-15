<template>
  <div class="w-100 h-100">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Company</h1>
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
                      :class="[
                                                errorName ? 'is-invalid' : ''
                                            ]"
                    />

                    <span
                      v-if="errorName"
                      class="error invalid-feedback"
                      id="name-error"
                    >{{ errorName }}</span>
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
                      id="name-error"
                    >{{ errorEmail }}</span>
                  </div>

                  <div class="form-group">
                    <label for="website">Website</label>
                    <input
                      v-model="website"
                      class="form-control"
                      id="website"
                      type="url"
                      placeholder="Enter company website"
                      :class="[
                                                errorWebsite ? 'is-invalid' : ''
                                            ]"
                    />

                    <span
                      v-if="errorWebsite"
                      class="error invalid-feedback"
                      id="name-error"
                    >{{ errorWebsite }}</span>
                  </div>

                  <div class="form-group">
                    <label for="compay-logo">Company Logo</label>
                    <div class="w-100 mb-2" v-if="logoUrl">
                      <img :src="logoUrl" style="max-width: 100px; max-height: 100px" />
                    </div>
                    <div class="input-group">
                      <div class="custom-file">
                        <input
                          @change="fileUploaded"
                          class="custom-file-input"
                          id="compay-logo"
                          type="file"
                          :class="[
                                                        errorLogo
                                                            ? 'is-invalid'
                                                            : ''
                                                    ]"
                        />
                        <label class="custom-file-label" for="compay-logo">{{ fileName }}</label>
                      </div>
                    </div>
                    <span
                      v-if="errorLogo"
                      class="error invalid-feedback"
                      id="company-logo-error"
                      :style="{
                                                display: errorLogo
                                                    ? 'block'
                                                    : 'none'
                                            }"
                    >{{ errorLogo }}</span>
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
        this.logoUrl = response.data.logo;
      })
      .catch((err) => {
        console.log(err);
      });
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
      load: "company/editCompany",
      update: "company/updateCompany",
    }),
    fileUploaded(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.logo = files[0];
      this.fileName = this.logo.name;
    },
    submit() {
      this.errors = {};

      let data = {
        id: this.id,
        formData: new FormData(),
      };
      data.formData.append("_method", "put");
      data.formData.append("name", this.name);

      if (this.email) {
        data.formData.append("email", this.email);
      }

      if (this.website) {
        data.formData.append("website", this.website);
      }

      if (this.logo) {
        data.formData.append("company_logo", this.logo);
      }

      this.update(data)
        .then((response) => {
          EventBus.$emit("UPDATE_COMPANY_NOTIFICATION", {
            title: "Update",
            message: `${response.data.name} has been added.`,
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
