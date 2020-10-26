<template>
    <div>
        <div v-if="items.length > 0">
            <div v-for="item in items" :key="item.id">
                <reply-component :attributes="item" @deleted="refreshReplies" />
            </div>
        </div>

        <div v-else>
            No replies yet.
        </div>
    </div>
</template>

<script>
    import ReplyComponent from "./ReplyComponent";

    export default {
        name: 'RepliesComponent',

        components: {
            ReplyComponent,
        },

        props: {
            replies: {
                type: Object,
                default: null
            },
        },

        data() {
            return {
                items: this.replies.data
            }
        },

        methods: {
            refreshReplies(e) {
                return this.items = this.items.filter(function (item) {
                    return item.id !== e;
                });
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>