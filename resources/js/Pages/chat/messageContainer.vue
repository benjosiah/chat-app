<template>
    <div class="h-96">
       <div class="h-full w-full px-5 flex flex-col-reverse overflow-scroll">
           <div v-for="(message, index) in messages" :key="index">
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