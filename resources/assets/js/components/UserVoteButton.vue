<template>
    <button
            class="btn btn-default"
            v-text="text"
            v-on:click="vote"
            v-bind:class="{'btn-primary':voted}"
    ></button>
</template>

<script>
    export default {
        props:['answer', 'count'],
        mounted() {
            axios.post('/api/answer/'+this.answer+'/votes/users').then(response => {
                this.voted = response.data.voted
            });
        },
        data() {
            return {
                voted: false
            }
        },
        computed: {
            text() {
                return this.count
            }
        },
        methods: {
            vote() {
                axios.post('/api/answer/vote/' + this.answer).then(response => {
                    this.voted = response.data.voted;
                    response.data.voted ? this.count ++ : this.count --
                });
            }
        }
    }
</script>
