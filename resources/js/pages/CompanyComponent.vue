<template>
  <div class="w-100 h-100">
    <Notification :event-name="notificationEvents"></Notification>
    <template v-if="isCompanyIndex">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Companies</h1>
            </div>
            <div class="col-sm-6">
              <div class="float-sm-right">
                <button class="btn btn-success float-right" type="button" @click.prevent="addNew">
                  <i class="fas fa-plus"></i>
                  &nbsp;Add Company
                </button>
              </div>
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

                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Logo</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Website</th>
                          <th>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody v-if="companies.length">
                        <TableRow v-for="company in companies" :key="company.id" :company="company"></TableRow>
                      </tbody>

                      <tbody v-if="!companies.length">
                        <tr>
                          <th colspan="6">No Company found!</th>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-12 d-flex justify-content-center">
                    <pagination :data="pagination" :limit="10" @pagination-change-page="load"></pagination>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.companies -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </template>

    <template v-if="!isCompanyIndex">
      <router-view />
    </template>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import TableRow from "../components/company/TableRowCompnent";
import Pagination from "laravel-vue-pagination";
import Notification from "../components/NotificationComponent";

export default {
  data: () => {
    return {
      notificationEvents: [
        "ADD_NEW_COMPANY_NOTIFICATION",
        "DELETE_COMPANY_NOTIFICATION",
        "UPDATE_COMPANY_NOTIFICATION",
        "ADD_NEW_EMPOYEE_NOTIFICATION",
      ],
    };
  },
  created() {
    this.load();
  },

  computed: {
    ...mapGetters({
      companies: "company/companies",
      pagination: "company/pagination",
    }),
    isCompanyIndex() {
      return this.$route.name === "company";
    },
  },
  methods: {
    ...mapActions({
      load: "company/loadCompanies",
    }),
    addNew() {
      this.$router.push({ name: "addNewCompany" });
    },
  },
  components: {
    TableRow,
    Pagination,
    Notification,
  },
};
</script>
