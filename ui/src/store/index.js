import { createStore } from "vuex";
import http from "@/services/http";

export default createStore({
  state: {
    bb_seasons: null,
    bcs_seasons: null,
    character: null,
    characters: null,
    global_error: "",
    processing: 0,
    quotes: null,
  },
  getters: {
    isProcessing() {
      return this.processing > 0;
    },
  },
  mutations: {
    bb_seasons(state, value) {
      state.bb_seasons = value;
    },
    bcs_seasons(state, value) {
      state.bcs_seasons = value;
    },
    character(state, value) {
      state.character = value;
    },
    characters(state, value) {
      state.characters = value;
    },
    decrement_processing() {
      this.processing--;
    },
    global_error(state, value) {
      state.global_error = value;
    },
    increment_processing() {
      this.processing++;
    },
    quotes(state, value) {
      state.quotes = value;
    },
  },
  actions: {
    async bbSeasonList({ commit }) {
      const data = await http.get("bb-appearances/seasons");
      commit("bb_seasons", data);
    },
    async bcsSeasonList({ commit }) {
      const data = await http.get("bcs-appearances/seasons");
      commit("bcs_seasons", data);
    },
    async characterGet({ commit }, character_id) {
      commit("character", null);
      const data = await http.get(`characters/${character_id}`);
      commit("character", data);
    },
    async characterList({ commit }) {
      const data = await http.get("characters");
      commit("characters", data);
    },
    async quotesGet({ commit }, name) {
      commit("quotes", null);
      const data = await http.get(`characters/quotes/${name}`);
      commit("quotes", data);
    },
  },
  modules: {},
});
