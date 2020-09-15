import axios from "axios";

const company = {
    namespaced: true,
    state: () => ({
        companies: {}
    }),
    mutations: {
        SET_COMPANIES: (state, payload) => {
            state.companies = payload;
        },
        UPDATE_COMPANY_COLLECTION_ITEM: (state, payload) => {
            state.companies.data.map(item => {
                if (item.id === payload.id) {
                    item.name = payload.name;
                    item.email = payload.email;
                    item.website = payload.website;
                    item.logo = payload.logo;
                }
            });
        }
    },
    actions: {
        loadCompanies: (context, payload) => {
            let pageNumber = payload || 1;
            axios
                .get(`/api/v1/companies?page=${pageNumber}`)
                .then(response => {
                    context.commit("SET_COMPANIES", response.data);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        addNewCompany: (context, payload) => {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/v1/companies`, payload)
                    .then(response => {
                        context.dispatch("loadCompanies", 1);
                        resolve(response);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        deleteCompany: (context, payload) => {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/v1/companies/${payload}`)
                    .then(response => {
                        context.dispatch("loadCompanies", 1);
                        resolve(response);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },

        editCompany: (context, payload) => {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/v1/companies/${payload}/edit`)
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },

        updateCompany: (context, payload) => {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/v1/companies/${payload.id}`, payload.formData)
                    .then(response => {
                        context.commit(
                            "UPDATE_COMPANY_COLLECTION_ITEM",
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
        companies: state => {
            if (state.companies.data) {
                return state.companies.data;
            }
            return [];
        },

        pagination: state => {
            return state.companies;
        }
    }
};

export default company;
