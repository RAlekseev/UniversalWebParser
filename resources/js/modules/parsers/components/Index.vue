<template>

    <div>
        <Create @create="onCreate($event)"></Create>

        <div class="card shadow mb-4" v-for="parser in parsers">
            <Parser :parser="parser"></Parser>
        </div>
    </div>
</template>

<script>
    import Create from "./Create";
    import Parser from "./Parser";
    import {mapGetters} from "vuex";

    export default {
        components: {
            Create,
            Parser
        },
        mounted() {
            this.$store.dispatch('getParsers');
        },
        computed: {
            ...mapGetters([
                'parsers',
            ])
        },
    }
</script>
