<template>
  <div class="w-100 h-100">
    <Notification :event-name="notificationEvents"></Notification>

    <template v-if="isIndex">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Employees</h1>
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

                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Company</th>
                          <th>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody v-if="employees.length">
                        <TableRow
                          v-for="employee in employees"
                          :key="employee.id"
                          :employee="employee"
                        ></TableRow>
                      </tbody>

                      <tbody v-if="!employees.length">
                        <tr>
                          <th colspan="6">No employee found!</th>
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
              <!-- /.employee-->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </template>

    <template v-if="!isIndex">
      <router-view />
    </template>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import TableRow from "../components/employee/TableRowCompnent";
import Pagination from "laravel-vue-pagination";
import Notification from "../components/NotificationComponent";

export default {
  data: () => {
    return {
      notificationEvents: [
        "DELETE_EMPLOYEE_NOTIFICATION",
        "UPDATE_EMPLOYEE_NOTIFICATION",
      ],
    };
  },

  created() {
    this.load();
  },

  computed: {
    ...mapGetters({
      employees: "employee/employees",
      pagination: "employee/pagination",
    }),
    isIndex() {
      return this.$route.name === "employee";
    },
  },

  methods: {
    ...mapActions({
      load: "employee/loadEmployees",
    }),
    // addNew() {
    //   console.log("add new page called");
    //   //this.$router.push({ name: "addNewCompany" });
    // },
  },

  components: {
    Pagination,
    Notification,
    TableRow,
  },
};
</script>
