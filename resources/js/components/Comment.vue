<template>
   <div class="flex justify-between">
       <div>
           {{ comment.body }}
       </div>
      <div>
          <router-link class="link link-primary" :to="{name: 'user.show', params: {id: comment.user.id}}">{{ comment.user.name }}</router-link>
      </div>
   </div>
</template>

<script>

export default {
    name: "Comment",
    data() {
        return {
        }
    },
    props: ['comment'],
    mounted() {
    },
    methods: {
    }
}
</script>

<style scoped>

</style>
