<template>
    <div class="flex justify-between mb-8 text-sm">
        <div>
            Subscribers
            <div class="text-center">
                {{ stats.subscribers_count}}
            </div>
        </div>
        <div>Likes
            <div class="text-center">
                {{ stats.likes_count}}
            </div>
        </div>
        <div>
            Posts
            <div class="text-center">
                {{ stats.posts_count}}
            </div>
        </div>
        <div>Follows
            <div class="text-center">
                {{ stats.followings_count}}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Stat",
    props: [
        'stats'
    ]
}
</script>

<style scoped>

</style>
