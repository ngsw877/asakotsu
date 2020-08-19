<template>
  <div>
    <vue-tags-input
      v-model="tag"
      :tags="tags"
      :autocomplete-items="filteredItems"
      @tags-changed="newTags => tags = newTags"
    />
  </div>
</template>

<script>
import VueTagsInput from '@johmun/vue-tags-input';

export default {
  components: {
    VueTagsInput,
  },
  data() {
    return {
      tag: '',
      tags: [],
      autocompleteItems: [{
        text: 'Spain',
      }, {
        text: 'France',
      }, {
        text: 'USA',
      }, {
        text: 'Germany',
      }, {
        text: 'China',
      }],
    };
  },
  computed: {
    filteredItems() {
      return this.autocompleteItems.filter(i => {
        return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
      });
    },
  },
};
</script>
<style lang="css" scoped>
  .vue-tags-input {
    max-width: inherit;
  }
</style>
<style lang="css">
  .vue-tags-input .ti-tag {
    background: transparent;
    border: 1px solid #747373;
    color: #747373;
    margin-right: 4px;
    border-radius: 0px;
    font-size: 13px;
  }
</style>
