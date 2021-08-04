<template>
  <div v-show="show" class="alert alert-primary flash-alert" role="alert">
    {{ body }}
  </div>
</template>

<script>
export default {
  props: ["message"],

  data() {
    return {
      body: "",
      show: false,
    };
  },

  created() {
    if (this.message) {
      this.flash(this.message);
    }

    window.events.$on("flash", (message) => {
      this.flash(message);
    });
  },

  methods: {
    flash(message) {
      this.body = message;
      this.show = true;

      this.hide();
    },

    hide() {
      return setTimeout(() => {
        this.show = false;
        this.body = "";
      }, 3000);
    },
  },
};
</script>

<style>
.flash-alert {
  position: fixed;
  bottom: 25px;
  right: 25px;
}
</style>
