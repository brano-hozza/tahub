<template>
    <div>
        <h1>Friends</h1>
        <hr>
        <ul>
            <li v-for="friend in friends">
                {{friend.first_name}} {{friend.last_name}}
            </li>
        </ul>
        <hr>
        <h2>Pridaj priatela</h2>
        <label>Priatelov email:
            <input type="email" v-model="email">
        </label>
        <button v-on:click="addFriend">Pridaj</button>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "Friends",
        data(){
            return{
                friends:[],
                email: ""
            }
        },
        created() {
            this.getFriends();
        },
        methods:{
            getFriends(){
                let str = window.localStorage;
                let token = str.getItem("token");
                axios.post("api/mess/friends",
                    {
                        "api_token":token
                    }).then(response=>this.friends = response.data.friends)
                    .catch(e => console.log(e))
            },
            addFriend(){
                let str = window.localStorage;
                let token = str.getItem("token");
                axios.post("api/mess/friends/add",
                    {
                        "api_token":token,
                        "email":this.email
                    }).then(response=>{
                        console.log(response)
                        this.friends = response.data.friends
                        this.getFriends()
                })
                    .catch(e => console.log(e))
            }
        }
    }
</script>

<style scoped>

</style>
