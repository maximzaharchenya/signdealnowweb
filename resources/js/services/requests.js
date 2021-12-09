export default class RequestsServices {

    static countries() {
        let countries = null;
        let url = '/api/countries';

        return axios.get(url)
            .then(response => {
                if(response.status == 200) {
                    countries = response.data;
                    return countries
                }
            });
    }

    static statuses() {
        let statuses = null;
        let url = '/api/statuses';

        return axios.get(url)
            .then(response => {
                if(response.status == 200) {
                    statuses = response.data;
                    return statuses
                }
            });
    }

    static roles() {
        let roles = null;
        let url = '/api/roles';

        return axios.get(url)
            .then(response => {
                if(response.status == 200) {
                    roles = response.data;
                    return roles
                }
            });
    }

    static deal(id, user) {
        let deal = null;
        let url = '/api/deal/' + id;

        const options = {
            headers: {Authorization: "Bearer " + localStorage.getItem('token')}
        };

        return axios.get(url, options)
            .then(response => {
                if(response.status == 200) {
                    deal = response.data;

                    if (deal.additional_seller_data) deal.additional_seller_data = JSON.parse(deal.additional_seller_data);
                    if (deal.married_data) deal.married_data = JSON.parse(deal.married_data);
                    if (deal.additional_client_data) deal.additional_client_data = JSON.parse(deal.additional_client_data);
                    if (deal.client_data) deal.client_data = JSON.parse(deal.client_data);
                    if (deal.sign_info) deal.sign_info = JSON.parse(deal.sign_info);
                    if (deal.notary_fees) deal.notary_fees = JSON.parse(deal.notary_fees);
                    if (deal.fees) deal.fees = JSON.parse(deal.fees);
                    if (deal.notary && deal.notary.languages) deal.notary.languages = JSON.parse(deal.notary.languages);


                    deal.all_users = [];
                    deal.other_users = [];
                    deal.clients = [];
                    deal.seller = null;
                    deal.seller_bank_representative = [];

                    if (deal.users) deal.users.forEach(item => {

                        let user = {};
                        user.id = item.id;
                        user.name = item.name;
                        user.surname = item.surname;
                        user.profile_image = item.profile_image;
                        user.role = item.pivot.user_role;
                        user.from = item.pivot.from;
                        user.approved = item.pivot.approved;
                        user.sign_approved = item.pivot.sign_approved;
                        user.fees_approved = item.pivot.fees_approved;

                        if (user.role != 1 && user.role != 2) deal.other_users.push(user);
                        if (user.role == 1) deal.seller = user;
                        if (user.role == 2) deal.clients.push(user);
                        if (user.role == 10) deal.seller_bank_representative.push(user);

                        deal.all_users.push(user)

                    });

                    return deal;
                }
            });
    }


};

