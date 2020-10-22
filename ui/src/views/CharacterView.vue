<template>
  <div class="columns has-text-centered">
    <div class="column is-one-third is-offset-one-third pt-6">
      <div class="has-text-left mb-3">
        <button class="button" @click="onBackClick">Back</button>
      </div>
      <div v-if="character !== null" class="card">
        <div class="card-image">
          <figure class="image">
            <img :src="character.img" :alt="character.name" />
          </figure>
        </div>
        <div class="card-content">
          <div class="media">
            <div class="media-content">
              <p class="title is-4">
                {{ character.name }}
              </p>
              <p>
                Nickname: {{ character.nickname }}<br />
                Birthday: {{ character.birthday }}<br />
                Status: {{ character.status }}<br />
                Breaking Bad Seasons: {{ character.bb_appearances.join(", ")
                }}<br />
                Better Call Saul Seasons:
                {{ character.bcs_appearances.join(", ") }}<br />
                Occupations: {{ character.occupations.join(", ") }}<br />
              </p>
            </div>
          </div>
          <div v-if="quotes !== null && quotes.length > 0" class="content">
            <p class="title is-5">Quotes</p>
            <div class="has-text-left">
              <p v-for="quote in quotes" :key="quote.quote_id">
                {{ quote.quote }}<br />- {{ quote.series }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState } from "vuex";
export default {
  props: {
    character_id: {
      type: [Number, String],
      required: true,
    },
  },
  computed: {
    ...mapState(["character", "quotes"]),
  },
  watch: {
    character(new_val) {
      if (new_val !== null) {
        this.quotesGet(new_val.name.replace(/ /g, "+"));
      }
    },
  },
  created() {
    this.characterGet(this.character_id);
  },
  methods: {
    ...mapActions(["characterGet", "quotesGet"]),
    onBackClick() {
      this.$router.go(-1);
    },
  },
};
</script>
