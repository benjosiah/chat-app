<template>
    <div class="flex flex-wrap items-center justify-between "> 
        <div>
         
        </div>
        <select
            v-model="selected"
            @change="$emit('roomChanged', selected)"
            class="bg-gray-700 text-lg"
        >
            <option v-for="(chatRoom, index) in chatRooms" :key="index" :value="chatRoom">
                {{chatRoom.name}}
            </option>
            <option v-if="currentRoom.team.id !== 1" value="group">  
                Create Group
            </option>
            <option @click="$emit('open', showinvite )" value="add"> 
                Add member to team
            </option>
        </select>
    </div>
</template>
<script>
export default {
    props:['currentRoom', 'chatRooms', 'teams', 'showCreateTeam', 'showCreateGroup', 'showinvite'],
    data(){
        return{
            selected:'',
            team:""
        }
    },
     watch: {
        currentRoom(oldRoom){
            this.selected = this.currentRoom
        }
    },
    created() {
        this.selected = this.currentRoom
        this.team = this.currentRoom.team.name
    }
}
</script>