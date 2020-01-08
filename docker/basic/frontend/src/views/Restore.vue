<template>
    <div>
        <vue-headful title="Восстановление"/>
    <div class="login-container d-flex align-items-center justify-content-center">
        <form class="login-form" method="send" @submit.prevent="submitHandler">
            <img class="icon-header" src="../assets/img/icon.svg">
            <div class="form-group">
                <input id="email"
                       type="text"
                       v-model.trim="email"
                       :class="{invalid: ($v.email.$dirty && !$v.email.required) || ($v.email.$dirty && !$v.email.email)}"
                       class="form-control input"
                       placeholder="Электронный адрес">
                <small
                        id = "emailEmpty"
                        class="helper-text invalid"
                        v-if="$v.email.$dirty && !$v.email.required"
                >Поле не должно быть пустым</small>
                <small
                        id="emailIncorrect"
                        class="helper-text invalid"
                        v-else-if="$v.email.$dirty && !$v.email.email"
                >Введите корректный электронный адрес</small>
            </div>
            <div class="form-group">
                <input type="submit" class="form-control input submit login" value="Отправить пароль" required>
            </div>
            <div>
                <router-link to="/login">
                    <a>Отмена</a>
                </router-link>
            </div>
        </form>
    </div>
    </div>
</template>

<script>
    import {email, required} from "vuelidate/lib/validators"

    export default {
        name: "Restore",
        data() {
            return {
                email: '',
            };
        },
        validations: {
            email: {email, required},
        },
        methods:{
            submitHandler(){
                if(this.$v.$invalid){
                    this.$v.$touch();
                    return;
                }
                this.$router.push('/login');
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
</style>