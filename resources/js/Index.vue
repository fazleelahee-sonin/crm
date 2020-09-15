<template>
  <div class="wrapper" id="app">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" v-if="authenticated">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#" @click.prevent="signOut">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" v-if="authenticated">
      <!-- Brand Logo -->
      <router-link to="/" class="brand-link">
        <img
          src="//via.placeholder.com/160"
          alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3"
          style="opacity: .8"
        />
        <span class="brand-text font-weight-light">CRM</span>
      </router-link>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="//via.placeholder.com/160" class="img-circle elevation-2" alt="User Image" />
          </div>
          <div class="info">
            <a href="#" class="d-block">{{user.name}}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul
            class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
            role="menu"
            data-accordion="false"
          >
            <li class="nav-item">
              <router-link to="/company" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Companies</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/employee" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>Employees</p>
              </router-link>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <router-view />
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>
        Copyright &copy; {{copyrightYear}}
        <a href="https://adminlte.io">CRM</a>.
      </strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      contentWrapperEl: null,
      mainFooterEl: null,
    };
  },

  created() {
    document.body.classList.add("sidebar-mini");
  },
  mounted() {
    this.contentWrapperEl = document.querySelector(".content-wrapper");
    this.mainFooterEl = document.querySelector(".main-footer");
    if (this.$route.name === "login") {
      localStorage.setItem(
        "margin-left",
        this.contentWrapperEl.style.marginLeft
      );
      this.contentWrapperEl.style.marginLeft = 0;
      this.mainFooterEl.style.marginLeft = 0;
    }
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),

    copyrightYear() {
      let date = new Date();
      return date.getFullYear();
    },

    routeName() {
      return this.$route.name;
    },
  },
  components: {},
  methods: {
    ...mapActions({
      signOutAction: "auth/signOut",
    }),

    async signOut() {
      await this.signOutAction();
      this.$router.replace({ name: "login" });
    },
  },

  watch: {
    routeName(newVal, oldeVal) {
      if (newVal !== "login") {
        this.contentWrapperEl.style.marginLeft =
          localStorage.getItem("margin-left") || "250px";
        this.mainFooterEl.style.marginLeft = this.contentWrapperEl.style.marginLeft;
      } else {
        this.contentWrapperEl.style.marginLeft = 0;
        this.mainFooterEl.style.marginLeft = 0;
      }
    },
  },
};
</script>
