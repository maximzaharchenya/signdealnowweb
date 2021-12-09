import RequestsServices from '../services/requests';
window.axios = require('axios');

let all_statuses;
RequestsServices.statuses().then(response => {
    all_statuses = response;
});

let all_roles;
RequestsServices.roles().then(response => {
    all_roles = response;
});



let echoDate = function(date) {
    let jsDate = new Date(date);
    let day = jsDate.getDate();
    if(day < 10) day = '0' + day;
    let month = 1 + jsDate.getMonth();
    if(month < 10) month = '0' + month;
    let year = jsDate.getFullYear();

    return day + '.' + month + '.' + year;
};

let echoDateTime = function(date) {
    let days = echoDate(date);
    let jsTime = new Date(date);
    let hours = jsTime.getHours();
    let minutes = jsTime.getMinutes();

    if(minutes < 10) minutes = '0' + minutes;

    return days + ' ' + hours + ':' + minutes;
};

let getStatus = function (i) {
    let status;
    all_statuses.forEach(item => {
        if(item.value == i) {
            status =  item.name
        }
    });
    return status
};

let getRole = function(i) {
    let role;
    all_roles.forEach(item => {
        if(item.value == i) {
            role =  item.name
        }
    });
    return role
};


export {
    echoDate,
    echoDateTime,
    getStatus,
    getRole
}
