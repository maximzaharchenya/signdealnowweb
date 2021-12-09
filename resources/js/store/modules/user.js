export default {
    actions: {
        async fetchUser(ctx) {
            let get_user_url = '/api/user_show';

            if(ctx.state.token) {
                axios
                    .get(get_user_url, {
                        headers: {
                            Authorization: "Bearer " + ctx.state.token
                        }
                    })
                    .then(response => {
                        if (response.status == 200) {
                            ctx.commit('setUser', response.data);
                        } else {
                            console.log('User is not authenticated');
                            ctx.commit('setUser', null);
                        }
                    });
            }
        },
    },

    mutations: {
        setUser(state, user) {
            if(user.date_of_birth) {
                let jsDate = new Date(user.date_of_birth);
                let day = jsDate.getDate();
                if(day < 10) day = '0' + day;
                let month = 1 + jsDate.getMonth();
                if(month < 10) month = '0' + month;
                let year = jsDate.getFullYear();
                user.date_of_birth = day + '.' + month + '.' + year;
            }

            state.user = user;
        },

    },

    state: {
        user: null,
        token: localStorage.getItem('token') || ''
    },

    getters: {
        getUser(state) {
            return state.user
        }
    },
}
