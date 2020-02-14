<template>
    <div>
    <vue-headful
            title="Регистрация"/>
    <div class="login-container d-flex align-items-center justify-content-center">
        <form class="login-form" method="send" @submit.prevent="submitHandler">
            <img class="icon-header" src="../assets/img/icon.svg">
            <div class="form-group">
                <input id="login"
                       type="text"
                       v-model.trim="login"
                       :class="{invalid: ($v.login.$dirty && !$v.login.required) || ($v.login.$dirty && !$v.login.maxLength)}"
                       class="form-control input"
                       placeholder="Логин">
                <small
                        id = "loginEmpty"
                        class="helper-text invalid"
                       v-if="$v.login.$dirty && !$v.login.required">
                    Поле не должно быть пустым
                </small>
                <small
                        id = "loginLessCharacters"
                        class="helper-text invalid"
                       v-else-if="$v.login.$dirty && !$v.login.maxLength">
                    Логин должен быть меньше {{this.maxLengthLogin}} символов
                </small>
            </div>
            <div class="form-group">
                <input id="email"
                       type="text"
                       v-model.trim="email"
                       :class="{invalid: ($v.email.$dirty && !$v.email.required) || ($v.email.$dirty && !$v.email.email) || this.result === 'userExists'}"
                       class="form-control input"
                       placeholder="Электронный адрес">
                <small
                        id = "emailEmpty"
                        class="helper-text invalid"
                       v-if="$v.email.$dirty && !$v.email.required">
                    Поле не должно быть пустым
                </small>
                <small
                        id = "emailIncorrect"
                        class="helper-text invalid"
                       v-else-if="$v.email.$dirty && !$v.email.email">
                    Введите корректный электронный адрес
                </small>
                <small
                        if="userExist"
                        class="helper-text invalid"
                       v-else-if="this.result === 'userExists'">
                    Пользователь с таким адресом уже существует
                </small>
            </div>
            <div class="form-group">
                <input id="password"
                       type="password"
                       v-model.trim="password"
                       :class="{invalid: ($v.password.$dirty && !$v.password.required) || ($v.password.$dirty && !$v.password.minLength)}"
                       class="form-control input"
                       placeholder="Пароль">
                <small
                        id="passwordLessCharacter"
                        class="helper-text invalid"
                       v-if="($v.password.$dirty && !$v.password.minLength) ||($v.password.$dirty && !$v.password.required)">
                    Пароль должен быть не менее {{this.minLengthPassword}} символов
                </small>
            </div>
            <div class="form-group">
                <select id = "gender"
                        v-model.trim="gender"
                        :class="{invalid: ($v.gender.$dirty && !$v.gender.required)}"
                        class="custom-select">
                    <option value="" selected>Ваш пол...</option>
                    <option value="man">Мужчина</option>
                    <option value="woman">Женщина</option>
                    <option value="custom">Другой</option>
                </select>
                <small
                        id = "genderEmpty"
                        class="helper-text invalid"
                       v-if="$v.gender.$dirty && !$v.gender.required">
                    Поле не должно быть пустым
                </small>
            </div>
            <div class="text-from">Откуда Вы о нас узнали?</div>
            <div class="form-group">
                <div class="btn-group btn-group-toggle" id="fromToggle" data-toggle="buttons">
                    <label class="btn btn-secondary radio-button active" id="noneRadio">
                        <input type="radio" name="options"  @click="radioChecked('none')" autocomplete="off" checked> Не указано
                    </label>
                    <label class="btn btn-secondary radio-button" id="socialRadio">
                        <input type="radio" name="options"  @click="radioChecked('social')" autocomplete="off"> Соц. сети
                    </label>
                    <label class="btn btn-secondary radio-button" id="friendsRadio">
                        <input type="radio" name="options" @click="radioChecked('friends')" autocomplete="off"> Друзья
                    </label>
                </div>
            </div>
            <template v-if="this.fromName == 'social'">
            <div class="form-group">
                <input id="social"
                       v-model.trim="nameService"
                       type="text"
                       class="form-control input"
                       placeholder="Название социальной сети">
            </div>
            </template>
            <div class="form-group">
                <input type="submit" id="register" class="form-control input submit" value="Регистрация" required>
            </div>
            <router-link to="/login">
                <a id="exit">Отмена</a>
            </router-link>
        </form>
    </div>
    </div>
</template>

<script>
    import {email, required, minLength, maxLength} from "vuelidate/lib/validators"
    import HTTP from "../components/http";

    export default {
        name: "Register",
        data() {
            return {
                login: '',
                email: '',
                password: '',
                fromName:'none',
                nameService:'',
                gender:'',
                minLengthPassword: 6,
                maxLengthLogin: 20,
                result:'',
                query:''
            };
        },
        validations: {
            email: {email, required},
            password : {required, minLength: minLength(6)},
            login: {required, maxLength:maxLength(20)},
            gender:{required}
        },
        methods:{
            radioChecked(name){
                this.fromName = name;
            },
            getCookie(name){
                var results = document.cookie.match ( '(^|;) ?' + name + '=([^;]*)(;|$)' );
                if ( results )
                    return ( unescape ( results[2] ) );
                else
                    return null;
            },
            saveToken(token){
                document.cookie = "accessToken="+token;
            },
            registerNewAccount(){
                HTTP.post('/user/add', {
                    login: this.login,
                    email: this.email,
                    password: this.password,
                    accessToken: null,
                    authKey: null,
                    image: null,
                    gender: this.gender,
                    cameFrom: this.fromName == 'social' ? (this.nameService.length == 0 ? this.fromName : this.nameService) : this.fromName,
                }).then(
                    (response) => {
                        this.result = response.data.status;
                        if(this.result == 'userCreated'){
                            this.saveToken(response.data.accessToken);
                            this.$router.push('/login');
                        }
                    },
                    (error) =>{
                        this.result = error.response.data;
                        console.log(error.response.data.result);
                    }
                )
            },
            submitHandler(){
                if(this.$v.$invalid){
                    this.$v.$touch();
                    return;
                }
                this.registerNewAccount();
            }
        }
    }
</script>

<style scoped>
    html{
        font-size: 16px;
    }

    hr{
        color: #000000;
    }
    body{
        background-color: #EDF0FA;
        font-family: 'Roboto', sans-serif;
    }

    a{
        color:#000000;
        text-decoration: none;
        opacity: 0.5;
        text-align: center;
        display: block;
        margin: auto;
    }

    span{
        opacity: .6;
    }

    a:hover,
    a:focus{
        color: #6C71F8;
        text-decoration: none;
    }

    .icon-header{
        width: 40px;
        height: 40px;
        max-width: 40px;
        max-height: 40px;
        display: block;
        margin: auto auto 20px;
    }

    .login-container{
        height: 100vh;
        width: 100%;
    }

    .login-form{
        max-width: 100%;
        width: 340px;
        padding: 15px;
        margin: auto;
    }
    .form-group{
        margin-bottom: 8px;
    }

    .input{
        font-size: 15px;
        border-radius: 5px;
        border: none;
        opacity: 1;
    }

    .input::placeholder{
        color: #000000;
        opacity: .4;
    }

    .input.submit{
        background-color: #2ADE3F;
        color: #FFFFFF;
    }

    .input.submit.login{
        background-color: #6C71F8;
        color: #FFFFFF;
    }

    .strike > span {
        position: relative;
        display: inline-block;
    }

    .strike > span:before,
    .strike > span:after {
        content: "";
        position: absolute;
        top: 50%;
        width: 9999px;
        height: 1px;
        background: black;
        opacity: 0.2;
    }

    .strike > span:before {
        right: 100%;
        margin-right: 15px;
    }

    .strike > span:after {
        left: 100%;
        margin-left: 15px;
    }

    .avatar-input:hover .avatar-input-hint,
    .avatar-input:focus .avatar-input-hint{
        visibility: visible;
    }

    .helper-text.invalid{
        color: rgba(243,33,89,.8);
    }

    .input.invalid{
        border: 1px solid rgba(243,33,89,.5);
    }

    .input.invalid:focus{
        box-shadow: 0 0 2px 1px rgba(243,33,89,.5);
        border: 1px solid rgba(243,33,89,.1);
    }

    .input:focus{
        box-shadow: 0 0 1px 2px rgba(108,113,248,.5);
    }


    .radio-button{
        background-color: #6C71F8;
        color: #FFFFFF;
        border: none;
    }

    .radio-button:hover,
    .radio-button:focus{
        background-color: #6C51B9;
        color: #FFFFFF;
        border: none;
        box-shadow: none;
    }

    .btn-secondary:not(:disabled):not(.disabled).active, .btn-secondary:not(:disabled):not(.disabled):active, .show>.btn-secondary.dropdown-toggle{
        background-color: #2ADE3F;
        border: none;
    }

    .btn-group{
        display: flex;
    }

    .text-from{
        color:#000000;
        text-decoration: none;
        opacity: 0.5;
        text-align: center;
        display: block;
        margin: auto;
    }

    .custom-select{
        display: flex;
        font-size: 15px;
        border-radius: 5px;
        border: none;
        opacity: 1;
    }

    .custom-select:focus{
        box-shadow: 0 0 1px 2px rgba(108,113,248,.5);
    }

    .custom-select.invalid{
        border: 1px solid rgba(243,33,89,.5);
    }

    .custom-select.invalid:focus{
        box-shadow: 0 0 2px 1px rgba(243,33,89,.5);
        border: 1px solid rgba(243,33,89,.1);
    }

</style>