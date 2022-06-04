<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{parser.name}}
                <button class="btn btn-success btn-round" @click="start()">
                    <i class="fa fa-play-circle"></i> Старт
                </button>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="data_table" class="display table-bordered" style="width:100%;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Img</th>
                        <th v-for="target in parser.targets">{{target.name}}</th>
                        <th>WebSite</th>
                        <th>Chat</th>
                        <th>Chat</th>
                        <th>Chat</th>
                        <th>Url</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="result in parser.results">
                        <td class="text-center">
                            <router-link :to="{ name: 'parserResultShow', params: { id: result.id } }">
                                {{result.id}}
                            </router-link>
                        </td>
                        <td>
                            <img width="50px" :src="result.images[0]" v-if="result.images.length">
                        </td>
                        <td v-for="i in [0, 1, 2, 3, 4]">
                            <span v-if="result.targets_result.length >= i && result.targets_result[i]">
                                {{result.targets_result[i]}}
                            </span>
                            <span v-else class="text-danger">0</span>
                        </td>
                        <td>
                            <a :href="result.internal_links[0].href" v-if="result.internal_links[0]">
                                {{limitStr(result.internal_links[0].href, 15)}}
                            </a>
                        </td>
                        <td>
                            <a :href="chatLinks(result.internal_links)[0].href" v-if="chatLinks(result.internal_links)[0]">
                                {{limitStr(chatLinks(result.internal_links)[0].href, 15)}}
                            </a>
                        </td>
                        <td>
                            <a :href="chatLinks(result.internal_links)[1].href" v-if="chatLinks(result.internal_links)[1]">
                                {{limitStr(chatLinks(result.internal_links)[1].href, 15)}}
                            </a>
                        </td>
                        <td>
                            <a :href="chatLinks(result.internal_links)[2].href" v-if="chatLinks(result.internal_links)[2]">
                                {{limitStr(chatLinks(result.internal_links)[2].href, 15)}}
                            </a>
                        </td>
                        <td>
                            <a :href="result.url">
                                {{result.url}}
                            </a>
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import dataTableConfig from "../../../core/utils/DataTablesConfig";

    window.JSZip = require( "jszip" );
    import 'datatables.net'

    import 'datatables.net-searchbuilder'
    import 'datatables.net-buttons/js/dataTables.buttons.js'
    import 'datatables.net-buttons/js/buttons.html5.js'
    import 'datatables.net-buttons/js/buttons.print.js'

    export default {
        computed: {
            ...mapGetters([
                'parser'
            ])
        },
        mounted() {
            // func() = setTimeout(window.$('#data_table').DataTable(dataTableConfig);
            this.$store.dispatch('getParser', this.$route.params.id).then(() => {
               function func() { window.$('#data_table').DataTable(dataTableConfig);}

                    setTimeout(func, 20000);
            });
        },
        methods: {
            start() {
                this.$store.dispatch('startParser', this.parser.id);
            },
            limitStr(str, n) {
                return str.substr(0, n) + (str.length > n ? "..." : "");
            },
            chatLinks(internal_links) {
                return internal_links.filter(link => link.text === "Chat");
            }
        },
    }
</script>
