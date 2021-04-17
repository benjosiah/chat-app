<template>
    <div class="h-96 pt-20 overflow-x-hidden overflow-y-scroll mt-20">
       <div class="h-full w-full px-5 flex flex-col-reverse">
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