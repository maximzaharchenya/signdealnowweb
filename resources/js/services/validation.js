import {required, minLength, maxLength, email, sameAs, helpers, numeric, requiredIf} from 'vuelidate/lib/validators';

const touchMap = new WeakMap();
const alpha = helpers.regex('alpha', /^[а-яА-Я \-\.]*$/);
const price = helpers.regex('alpha', /^[0-9,]+$/);
const code = helpers.regex('alpha', /^[a-zA-Z0-9]+$/);

const date = helpers.regex('alpha', /^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/);
// const alpha = helpers.regex('alpha', /^[a-zA-Z, а-яА-Я\-\.]*$/)


let nameRule = {
    required,
    minLength: minLength(4),
    maxLength: maxLength(50)
};


let emailRule = {
    required,
    email
};

let phoneRule = {
    required,
    minLength: minLength(19),
    maxLength: maxLength(19)
};

let passwordRule = {
    required,
    // minLength: minLength(8),
};

let passwordRepeatRule = {
    required,
    // minLength: minLength(8),
    sameAs: sameAs('password')
};

let personalNumberRule = {
    required,
    maxLength: maxLength(20),
    code
};

let personalNumberRuleIfPersonRule = {
    required: requiredIf(function (value) {
        return value.person == 1
    }),
    maxLength: maxLength(20),
    code
};

let personalNumberRuleNoReq = {
    maxLength: maxLength(20),
    code
};

let checkbox = {
    required,
    sameAs: sameAs(() => true)
};

let checkCodeRule = {
    required
};

let onlyLetterRule = {
    alpha
};

let onlyNumRule = {
    required,
    price
};

let requiredRule = {
    required
};

let shortDescRule = {
    required,
    maxLength: maxLength(100)
};

let shortDescNoReqRule = {
    maxLength: maxLength(100)
};

let priceRule = {
    required,
    price
};

let birthRule = {
    required,
    minLength: minLength(10),
    maxLength: maxLength(10),
    date
};

let birthRuleNoReq = {
    minLength: minLength(10),
    maxLength: maxLength(10),
    date
};

let onlyNumRuleNoReq = {
    price
};

let emailRuleNoReq = {
    email
};

let requiredIfRule = {
    required: requiredIf(function () {
        return 'person.$model' == 2
    })
};

let requiredRuleAttorney = {
    required: requiredIf(function () {
        let valid = true;
        if(this.load_representative_power_of_attorney == false || 'representative_power_of_attorney') valid = false;
        return valid
    })
};

let noValid = {
    minLength: minLength(1)
};

let requiredIfPersonRule = {
    required: requiredIf(function (value) {
        return value.person == 1
    }),
    minLength: minLength(1)
};

let birthIfPersonRule = {
    required: requiredIf(function (value) {
        return value.person == 1
    }),
    minLength: minLength(10),
    maxLength: maxLength(10),
    date
};

let requiredIfNoPersonRule = {
    required: requiredIf(function (value) {
       return value.person == 0
    }),
    minLength: minLength(1)
};
let requiredIfFile = {
    required: requiredIf(function () {
        return false
    }),
};



export {
    nameRule,
    emailRule,
    emailRuleNoReq,
    checkbox,
    requiredRule,
    birthRule,
    onlyNumRule,
    onlyNumRuleNoReq,
    birthRuleNoReq,
    requiredIfRule,
    requiredRuleAttorney,
    noValid,
    requiredIfPersonRule,
    birthIfPersonRule,
    requiredIfNoPersonRule,
    requiredIfFile,
    personalNumberRule,
    personalNumberRuleIfPersonRule,
    personalNumberRuleNoReq,

    passwordRule,
    passwordRepeatRule,
    checkCodeRule,
    onlyLetterRule,
    phoneRule,
    shortDescRule,
    shortDescNoReqRule,
    priceRule,
};
