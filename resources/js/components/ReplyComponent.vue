<template>
  <div class="mb-3">
    <div :id="`reply-${attributes.id}`" class="card mb-2">
      <div class="card-header d-flex justify-content-between">
        <p>{{ attributes.owner.name }} at {{ formattedDate }}</p>

        <div class="d-flex">
          <!--                @auth-->
          <form class="mr-1" @submit.prevent="toggleFavorite" method="POST">
            <button
              class="btn btn-sm"
              :class="isFavorited ? 'btn-primary' : 'btn-secondary'"
              type="submit">
                {{ formattedFavoritesCount }}
            </button>
          </form>
          <!--                @endauth-->
        </div>
      </div>

      <div v-if="editing" class="p-2">
        <form @submit.prevent="updateReply">
          <textarea class="form-control p-1 mb-2" name id cols="10" rows="5" :value="replyBody"></textarea>

          <button class="btn btn-sm btn-secondary" type="submit">Save</button>
          <button class="btn btn-sm btn-secondary" @click="cancelChanges">Cancel</button>
        </form>
      </div>

      <div v-else class="card-body">{{ replyBody }}</div>

      <!--        @can('update', $reply)-->
      <div class="card-footer d-flex">
        <button class="btn btn-info btn-sm mr-1 form-group" @click="editing = true">Edit</button>

        <form @submit.prevent="deleteReply" method="POST">
          <button class="btn btn-danger btn-sm" type="submit">Delete</button>
        </form>
      </div>
      <!--        @endcan-->
    </div>
  </div>
</template>

<script>
import moment from 'moment';

export default {
  name: "ReplyComponent",

  props: {
    attributes: {
      type: Object,
      default: null,
    },
  },

  data() {
    return {
      editing: false,
      replyBody: this.attributes.body,
      favoritesCount: this.attributes.favoritesCount,
      isFavorited: this.attributes.isFavorited,
    };
  },

  created() {
    console.log(this.attributes);
  },

  computed: {
    favoriteRoute() {
      return `/replies/${this.attributes.id}/favorites`;
    },

    deleteRoute() {
      return `/replies/${this.attributes.id}`;
    },

    updateRoute() {
      return this.deleteRoute;
    },

    formattedDate() {
      return moment(this.attributes.created_at).calendar();
    },

    formattedFavoritesCount() {
      // {{ attributes.favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
      return this.favoritesCount + ' favs';
    },
  },

  methods: {
    toggleFavorite() {
      if (this.isFavorited) {
        return this.unfavorite();
      }

      return this.favorite();
    },

    favorite() {
      axios.post(this.favoriteRoute).then((response) => {
        this.favoritesCount++;
        this.isFavorited = true;
        flash(response.data.message);
      });
    },

    unfavorite() {
      axios.delete(this.favoriteRoute).then((response) => {
        this.favoritesCount--;
        this.isFavorited = false;
        flash(response.data.message);
      });
    },

    deleteReply() {
      axios.delete(this.deleteRoute).then((response) => {
        this.notifyParent();
      });
    },

    notifyParent() {
      this.$emit('deleted', this.attributes.id);
    },

    updateReply(e) {
      axios
        .patch(this.updateRoute, {
          body: e.target[0].value,
        })
        .then((response) => {
          this.replyBody = response.data.reply.body;
          this.editing = false;
          flash(response.data.message);
        })
        .catch((errors) => {
          console.log(errors);
        });
    },

    cancelChanges() {
      if (this.replyIsChanged) {
        this.replyBody = this.attributes.body;
      }

      return (this.editing = false);
    },

    replyIsChanged() {
      return this.replyBody !== this.attributes.body;
    },
  },
};
</script>

<style scoped>
</style>
