<template>
    <button
            class="btn btn-default"
            v-text="text"
            v-on:click="follow"
            v-bind:class="{'btn-success':followed}"
    ></button>
</template>

<script>
    export default {
        props:['user'],
        mounted() {
            axios.get('/api/user/'+this.user+'/followers').then(response => {
                this.followed = response.data.followed
            });
        },
        data() {
            return {
                followed: false
            }
        },
        computed: {
            text() {
                return this.followed ? '已关注' : '关注他';
            }
        },
        methods: {
            follow() {
                axios.post('/api/user/follow', {'user': this.user}).then(response => {
                    this.followed = response.data.followed
                });
            }
        }
    }
</script>
