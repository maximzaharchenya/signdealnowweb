window.axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    let message;
    if(error && error.response) {
        switch (error && error.response.status) {
            case 400:
                message = error.response.data.error;
                let messages = [];
                for (key in message) {
                    messages.push(message[key])
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Неверные данные',
                    html: messages,
                });
                break;
            case 500:
                message = error.response.data.error;
                Swal.fire({
                    icon: 'error',
                    title: 'Упс...',
                    html: message,
                });
                break;
            default:
                return Promise.reject(error);
        }
    }

});
