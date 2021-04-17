<template>
    <app-layout>
        <template #header >
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                <chat-room-seection
                    v-if="currentRoom.id"
                    :currentRoom="currentRoom"
                    :chatRooms="chatRooms"
                    v-on:roomChanged="setRoom( $event )"
                />
            </h2>
        </template>
        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg bg-gray-100"> 
                    <message-container :messages="messages"/>
                    <message-input :room="currentRoom"
                    v-on:messagesent="getMessages()"
                    />
                    
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import MessageContainer from './chat/messageContainer.vue'
    import MessageInput from './chat/MessageInput.vue'
    import ChatRoomSeection from './chat/ChatRoomSeection.vue'

    export default {
        components: {
            AppLayout,
            Welcome,
            MessageContainer,
            MessageInput,
            ChatRoomSeection,
        },
        data(){
            return{
                chatRooms:[],
                currentRoom:[],
                messages: [],
            }
        },
        watch: {
            currentRoom(oldRoom, newRoom){
                if(oldRoom.id){
                    this.disconnect(oldRoom)
                }
                this.connect()
            }
        },
        methods:{
            connect(){
                if (this.currentRoom.id) {
                    let vm = this;
                    this.getMessages();
                    window.Echo.private("chat."+this.currentRoom.id).
                        listen('NewChatMessage',e=>{
                        vm.getMessages();
                    });
                }
            },
            disconnect( room ){
                window.Echo.leave('chat'+room.id);
            },
            getRooms(){
                axios.get('/chat/rooms').then(res=>{
                    this.chatRooms = res.data;
                    this.setRoom(this.chatRooms[0])
                }).catch(err =>{
                    console.log(err)
                })
            },
            setRoom(rooms){
                this.currentRoom = rooms;
             
            },
            getMessages(){
                axios.get('/chat/'+this.currentRoom.id+'/messages').then(messages=>{
                    this.messages = messages.data;
                }).catch(err =>{
                    console.log(err)
                })
            }
        },
        created(){
            this.getRooms();
        }
    }
</script>
