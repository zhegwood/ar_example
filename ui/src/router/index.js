import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/",
    name: "CharactersList",
    component: () =>
      import(
        /* webpackChunkName: "characterlist" */ "../views/CharacterList.vue"
      ),
  },
  {
    path: "/character/:character_id",
    name: "CharacterView",
    props: true,
    component: () =>
      import(
        /* webpackChunkName: "characterview" */ "../views/CharacterView.vue"
      ),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
