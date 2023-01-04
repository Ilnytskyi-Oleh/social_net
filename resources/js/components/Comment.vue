<template>
   <div class="">
          <div class="flex text-sm items-center">
              <router-link class="link link-primary " :to="{name: 'user.show', params: {id: comment.user.id}}">{{ comment.user.name }}</router-link>
              <svg
                  @click="this.$emit('reply')"
                  xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 fill-white cursor-pointer hover:opacity-60 ml-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
              </svg>
              <div class="ml-auto ">
                  {{ comment.date }}
              </div>
          </div>
       <div>
          <p v-if="comment.answered_for_user"> Answered to <b>{{ comment.answered_for_user }} </b></p>
           {{ comment.body }}
       </div>
       <hr>
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
