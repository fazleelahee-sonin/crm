<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login</div>

          <div class="card-body">
            <form action="#" @submit.prevent="submit">
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                <div class="col-md-6">
                  <input
                    type="text"
                    name="email"
                    v-model="form.email"
                    class="form-control"
                    required
                    autocomplete="email"
                    autofocus
                    :class="[invalid ? 'is-invalid': '']"
                  />
                  <span class="invalid-feedback" role="alert" v-if="invalid">
                    <strong>These credentials do not match our records.</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                  <input type="password" class="form-control" v-model="form.password" />
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    <i class="fa fa-unlock" aria-hidden="true"></i>
                    Login
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapActions } from "vuex";

export default {
  data: () => {
    return {
      form: {
        email: "",
        password: "",
      },
      invalid: false,
    };
  },
  mounted() {},
  methods: {
    ...mapActions({
      signIn: "auth/signIn",
    }),

    async submit() {
      this.invalid = false;
      await this.signIn(this.form)
        .then(() => {
          this.$router.push({ name: "company" });
        })
        .catch(() => {
          this.invalid = true;
        });
    },
  },
};
</script>
