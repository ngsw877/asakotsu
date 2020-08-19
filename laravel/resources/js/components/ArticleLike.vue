<template>
  <div>
    <button
      type="button"
      class="btn m-0 p-1 shadow-none"
    >
      <i class="fas fa-heart mr-1"
      :class="{'red-text':this.isLikedBy}"
      />
    </button>
    15
  </div>
</template>

<script>
  export default {
    props: {
      initialIsLikedBy: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {
        isLikedBy: this.initialIsLikedBy,
      }
    },
  }
</script>
