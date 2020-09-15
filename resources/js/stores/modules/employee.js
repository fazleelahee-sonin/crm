import axios from "axios";

const employee = {
    namespaced: true,
    state: () => ({
        employees: {}
    }),
    mutations: {
        SET_EMPLOYEES: (state, payload) => {
            state.employees = payload;
        },
        UPDATE_EMPLOYEES_COLLECTION_ITEM: (state, payload) => {
            state.employees.data.map(item => {
                if (item.id === payload.id) {
                    item.first_name = payload.first_name;
                    item.last_name = payload.last_name;
                    item.email = payload.email;
                    item.phone = payload.phone;
                }
            });
        }
    },

    actions: {
        loadEmployees: (context, payload) => {
            let pageNumber = payload || 1;
            axios
                .get(`/api/v1/employees?page=${pageNumber}`)
                .then(response => {
                    context.commit("SET_EMPLOYEES", response.data);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        addNewEmployee: (context, payload) => {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/v1/employees`, payload)
                    .then(response => {
                        context.dispatch("loadEmployees", 1);
                        resolve(response);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },

        deleteEmployee: (context, payload) => {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/v1/employees/${payload}`)
                    .then(response => {
                        context.dispatch("loadEmployees", 1);
                        resolve(response);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        editEmployee: (context, payload) => {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/v1/employees/${payload}/edit`)
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        updateEmployee: (context, payload) => {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/v1/employees/${payload.id}`, payload.formData)
                    .then(response => {
                        context.commit(
                            "UPDATE_EMPLOYEES_COLLECTION_ITEM",
                            response.data.data
                        );
                        resolve(response.data);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        }
    },
    getters: {
        employees: state => {
            if (state.employees.data) {
                return state.employees.data;
            }
            return [];
        },

        pagination: state => {
            return state.employees;
        }
    }
};

export default employee;
