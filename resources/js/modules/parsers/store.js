import axios from 'axios';

export default {
    state: {
        parsers: [],
        parser: null,
    },

    mutations: {
        getParsers(state, objects) {
            state.parsers = objects;
        },
        addParser(state, object) {
            state.parsers.push(object);
        },
        getParser(state, object) {
            state.parser = object;
        },
        updateParser(state, new_object) {
            let index = state.parsers.findIndex(item => item.id === new_object.id);
            state.parsers[index] = new_object;
        },
        deleteParser(state, id) {
            let index = state.parsers.findIndex(item => item.id === id);
            state.parsers.splice(index, 1);
        },
        addResults(state, results, parser_id) {
            state.parsers.find(item => item.id === parser_id).results.concat(results);
        }
    },

    actions: {
        getParsers({commit}) {
            return axios
                .get('/api/parsers')
                .then(response => {
                    commit('getParsers', response.data);
                }).catch(error => {
                    commit('addError', error.response.data.message || error.message);
                });
        },
        createParser({commit}, credential) {
            commit('startLoading');
            return axios
                .post('/api/parsers', credential)
                .then(response => {
                    commit('addService', response.data.parser);
                    commit('addMessage', response.data.message);
                }).catch(error => {
                    commit('addError', error.response.data.message || error.message);
                }).finally(() => commit('stopLoading'));
        },
        getParser({commit}, id) {
            commit('startLoading');
            axios
                .get(`/api/parsers/${id}`)
                .then(response => {
                    commit('getParser', response.data);
                }).catch(error => {
                commit('addError', error.response.data.message || error.message);
            }).finally(() => commit('stopLoading'));
        },
        updateParser({commit}, credential) {
            commit('startLoading');
            return axios
                .patch(`/api/parsers/${credential.id}`, credential)
                .then(response => {
                    commit('updateParser', response.data.parser);
                    commit('addMessage', response.data.message);
                }).catch(error => {
                    commit('addError', error.response.data.message || error.message)
                }).finally(() => commit('stopLoading'));
        },
        deleteParser({commit}, id) {
            commit('startLoading');
            return axios
                .delete(`/api/parsers/${id}`)
                .then(() => {
                    commit('deleteParser', id);
                }).catch(error => {
                    commit('addError', error.response.data.message || error.message)
                }).finally(() => commit('stopLoading'));
        },
        startParser({commit}, id) {
            axios
                .get(`/api/parsers/start/${id}`)
                .then(response => {
                    commit('addResults', response.data.results, id);
                    commit('addMessage', response.data.message);
                }).catch(error => {
                commit('addError', error.response.data.message || error.message)
            }).finally(() => commit('stopLoading'));
        }
    },

    getters: {
        parsers: state => state.parsers,
        parser: state => state.parser,
    }
};
