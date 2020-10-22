<template>
  <div>
    <div class="pt-6 pb-3">
      <div class="field is-inline-block">
        <div class="control">
          <div class="select">
            <select v-model="show_filter">
              <option v-for="show in shows" :key="show" :value="show">
                {{ show.name }}
              </option>
            </select>
          </div>
        </div>
      </div>
      <div class="field is-inline-block ml-3">
        <div class="control">
          <div class="select">
            <select v-model="season_filter">
              <option v-for="season in seasons" :key="season" :value="season">
                Season {{ season }}
              </option>
            </select>
          </div>
        </div>
      </div>
      <div class="field is-inline-block ml-3">
        <div class="control">
          <input
            v-model="character_filter"
            class="input"
            type="text"
            placeholder="search for characters"
          />
        </div>
      </div>
    </div>
    <table class="table is-striped is-fullwidth is-hoverable">
      <thead>
        <tr>
          <th>Name</th>
          <th>Nickname</th>
          <th>Birthday</th>
          <th>Status</th>
          <th>Portrayed By</th>
          <th>Category</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="char in table_data"
          :key="char.id"
          class="cursor-pointer"
          @click="onRowClick(char)"
        >
          <td>{{ char.name }}</td>
          <td>{{ char.nickname }}</td>
          <td>{{ char.birthday }}</td>
          <td>{{ char.status }}</td>
          <td>{{ char.portrayed }}</td>
          <td>{{ char.category }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  computed: {
    ...mapState(["bb_seasons", "bcs_seasons", "characters"]),
    seasons() {
      return this[`${this.show_filter.abbr}_seasons`];
    },
    table_data() {
      if (this.characters === null) {
        return [];
      }
      return this.characters.filter((character) => {
        const show = character.category.indexOf(this.show_filter.name) >= 0;
        const seasons = character[`${this.show_filter.abbr}_appearances`];
        const includes_season = seasons.flat().includes(this.season_filter);
        const includes_name =
          this.character_filter === ""
            ? true
            : character.name
                .toLowerCase()
                .indexOf(this.character_filter.toLowerCase()) >= 0;

        return show === true && includes_season === true && includes_name;
      });
    },
  },
  data: () => ({
    character_filter: "",
    season_filter: 1,
    shows: [
      {
        abbr: "bb",
        name: "Breaking Bad",
      },
      {
        abbr: "bcs",
        name: "Better Call Saul",
      },
    ],
    show_filter: {
      abbr: "bb",
      name: "Breaking Bad",
    },
  }),
  created() {
    this.bbSeasonList();
    this.bcsSeasonList();
    this.characterList();
  },
  methods: {
    ...mapActions(["characterList", "bbSeasonList", "bcsSeasonList"]),
    onRowClick(char) {
      this.$router.push({
        name: "CharacterView",
        params: { character_id: char.id },
      });
    },
  },
};
</script>
