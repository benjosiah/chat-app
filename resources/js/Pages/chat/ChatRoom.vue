<template>
    <app-layout>
        <template #header >
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                <chat-room-seection
                    v-if="currentRoom.id"
                    :currentRoom="currentRoom"
                    :showCreateTeam="showCreateTeam"
                    :showCreateGroup="showCreateGroup"
                    :showinvite="showinvite"
                    :chatRooms="chatRooms"
                    :teams = "teams"
                    v-on:roomChanged="setRoom( $event )"
                    v-on:openteam="open( $event )"
                />
            </h2>
        </template>
        <div class="py-12 ">
            
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-600 ">
                <div class=" shadow-xl sm:rounded-lg bg-gray-200 ">
                    <message-container :messages="messages"/>
                    <message-input :room="currentRoom"
                    v-on:messagesent="getMessages()"
                    />
                  
                </div>
            </div>
        </div>

        <div v-if="showCreateGroup" class="md:w-1/3 sm:w-full bg-gray-100 p-10 absolute top-8 md:left-20 sm:left-0">
                <h3>Create Group</h3>
             <div>
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="name" required autofocus autocomplete="name" />
            </div>

            <div class="flex items-center justify-end mt-4">
               <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="newGroup()" >
                    Create
                </jet-button>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="close('group')">
                    Cancel
                </jet-button>
            </div>
        </div>

         <div v-if="showinvite" class="md:w-1/3 sm:w-full bg-gray-100 p-10 absolute top-8 md:left-20 sm:left-0">
                <h3>Add Member to </h3>
             <div>
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="name" required autofocus autocomplete="name" />
            </div>

            <div class="flex items-center justify-end mt-4">
               <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="newAdd()" >
                    Create
                </jet-button>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="close('add')">
                    Cancel
                </jet-button>
            </div>
        </div>
       
       
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import MessageContainer from './messageContainer.vue'
    import MessageInput from './MessageInput.vue'
    import ChatRoomSeection from './ChatRoomSeection.vue'
     import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'


    export default {
        props:['chatRooms', 'teams'],
        components: {
            AppLayout,
            Welcome,
            MessageContainer,
            MessageInput,
            ChatRoomSeection,
            JetButton,
            JetInput,
            JetLabel
        },
        data(){
            return{
                currentRoom:[],
                messages: [],
                team:[],
                showCreateTeam:false,
                showinvite:false,
                showCreateGroup:false,
                name:'',
                email:'',
                form:{}
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

            newGroup(){
                axios.post('/team/'+this.currentRoom.team.id+'/chat',{ 
                    'name':this.name,
                }).then(res =>{
                    if (res.status == 201) {
                        this.name = "";
                        this.close()
                    }
                }).catch(error =>{
                    console.log(error)
                })
            },

             newAdd(){
                axios.post('team/'+this.currentRoom.team.id,{ 
                    'email':this.name,
                }).then(res =>{
                    if (res.status == 201) {
                        this.name = "";
                        this.close('group')
                    }
                }).catch(error =>{
                    console.log(error)
                })
            },


            disconnect( room ){
                window.Echo.leave('chat'+room.id);
            },
            setRoom(room){
                if(room == 'add'){
                    if (this.showinvite==false) {
                        this.showinvite=true
                        this.currentRoom=this.chatRooms[0]
                    }
                }
                else if(room == 'group'){
                    if (this.showCreateGroup==false) {
                        this.showCreateGroup=true
                        this.currentRoom=this.chatRooms[0]
                    }
                }
                else{
                    this.currentRoom = room;
                    console.log(room)
                    this.getMessages();
                }
             
            },
            getMessages(){
                axios.get('/chat/'+this.currentRoom.id+'/messages').then(messages=>{
                    this.messages = messages.data;
                }).catch(err =>{
                    console.log(err)
                })
            },
            open(val){
                console.log(val)
                if (val=='team') {
                    this.showCreateTeam= true
                    console.log(val)
                }
            },
            close(val){
                if(val == 'team'){
                    this.showCreateTeam= false
                }
                else if(val =='group'){
                    this.showCreateGroup=false
                }
                else{
                    this.showinvite=false
                }
               
              
            }
        },
        created(){
            this.setRoom(this.chatRooms[0])
            
            
        }
    }
</script>
