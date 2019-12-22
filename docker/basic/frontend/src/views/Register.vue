<template>
    <div class="login-container d-flex align-items-center justify-content-center">
        <form class="login-form" method="get">
            <img class="icon-header" src="../assets/img/icon.svg">
            <div class="form-group">
                <input type="text" class="form-control input" placeholder="Логин" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control input" placeholder="Электронный адрес" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control input" placeholder="Пароль" required>
            </div>
            <div class="form-group">
                <input type="submit" class="form-control input submit" value="Регистрация" required>
            </div>
            <router-link to="/login">
                <a>Отмена</a>
            </router-link>
        </form>
    </div>
</template>

<script>
    export default {
        name: "Register"
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
</style>