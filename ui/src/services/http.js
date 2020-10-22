"use strict";

import axios from "axios";
import store from "@/store";
import router from "@/router";

// Full config:  https://github.com/axios/axios#request-config
// axios.defaults.baseURL = process.env.baseURL || process.env.apiUrl || '';
// axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
axios.defaults.headers.post["Content-Type"] = "application/json";
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let config = {
  baseURL: process.env.VUE_APP_API_URL || "",
  // timeout: 60 * 1000, // Timeout
  withCredentials: true,
};

const http = axios.create(config);

http.interceptors.request.use(
  function(config) {
    store.commit("global_error", "");
    store.commit("increment_processing");
    const token = localStorage.getItem("token");
    if (token) {
      config.headers.common.Authorization = `Bearer ${token}`;
    }
    // Do something before request is sent
    return config;
  },
  function(error) {
    store.commit("decrement_processing");
    // Do something with request error
    return Promise.reject(error);
  }
);

// Add a response interceptor
http.interceptors.response.use(
  function({ data }) {
    store.commit("decrement_processing");
    // Do something with response data
    return data;
  },
  function({ response }) {
    console.log("response error", response);
    store.commit("decrement_processing");
    if (response.data.message === "Token has expired") {
      store.commit("token", null);
      store.commit("auth_user", null);
      store.commit("global_error", "");
      localStorage.clear();
      router.push({ path: "/", query: { login: true } });
      store.commit("show_login_modal", "true");
    }
    if (response.status === 422 && response.data.errors) {
      const errors = [];
      for (const a in response.data.errors) {
        errors.push(response.data.errors[a].flat());
      }
      store.commit("global_error", errors.join("<br/>"));
    } else {
      store.commit("global_error", response.data.message);
    }
    // Do something with response error
    return Promise.reject(response);
  }
);

export default http;
