<template>
    <div class="h-96">
       <div class="h-full w-full px-5 flex flex-col-reverse overflow-y-scroll">
           <div v-for="(message, index) in messages" :key="index" class="">
               <message-item :message="message" />
           </div>
       </div>
    </div>
</template>
<script>
import MessageItem from './MessageItem.vue'
export default {
  components: { MessageItem },
    props:['messages']
}
</script>