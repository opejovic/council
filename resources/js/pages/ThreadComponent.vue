<template>
  <div class="container">
    <div class="row justify-content-start">
      <div class="col-md-8">
        <div class="card mb-5">
          <div
            class="card-header d-flex justify-content-between align-items-center"
          >
            <h4>{{ thread.title }}</h4>

            <div v-if="canupdatethread">
              <form
                :action="`/threads/${thread.category.slug}/${thread.id}`"
                method="post"
              >
                <button class="btn btn-sm btn-danger" type="submit">
                  Delete
                </button>
              </form>
            </div>
          </div>

          <div class="card-body">
            {{ thread.body }}
          </div>
        </div>

        <div class="pb-4">
          <replies-component :replies="replies" />
        </div>

        <!-- @if(auth()->check())
                    <div class="mt-16">
                        <form action="{{ $thread->path() }}/replies" method="POST">
                            @csrf
                            <textarea class="w-600 form-control" name="body" id="body" rows="6" placeholder="Have something to say?"></textarea>

                            <button type="submit" class="mt-2 form-control btn btn-primary">Reply</button>
                        </form>

                    </div>
                @else
                    <p class="text-center mt-4">Please <a href="/login">sign in</a> to participate in discussion.</p>
                @endif -->
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Thread information</div>

          <div class="card-body">
            This thread was published {{ publishedAt }}. It currently has
            {{ thread.replies_count }} replies.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";

export default {
  name: "ThreadComponent",

  props: {
    thread: {
      type: Object,
      default: null,
    },

    replies: {
      type: Object,
      default: null,
    },

    canupdatethread: {
      type: Boolean,
      default: false,
    },
  },

  computed: {
    publishedAt() {
      return moment(this.thread.created_at).calendar();
    },
  },
};
</script>