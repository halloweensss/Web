<template>
    <div class="login-container d-flex align-items-center justify-content-center">
        <form class="login-form" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="avatar-input rounded-circle">
                    <div class="avatar-input-hint">Изменить аватар</div>
                    <input class="file-input" type="file" multiple accept=".jpg,.jpeg,.png,.gif">
                </div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control input" placeholder="Логин" value="Halloween">
            </div>
            <div class="form-group">
                <input type="password" class="form-control input" placeholder="Пароль">
            </div>
            <div class="form-group">
                <input type="submit" class="form-control input submit" value="Сохранить">
            </div>
            <router-link to="/">
                <a href="index.html">Отмена</a>
            </router-link>
        </form>
    </div>
</template>

<script>
    export default {
        name: "Update"
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

    .avatar-input{
        background-image: url("../assets/img/sand.jpg");
        background-position: center;
        background-size: 100px 100px;
        width: 100px;
        height: 100px;
        display: flex;
        margin: auto;
    }

    .avatar-input:hover,
    .avatar-input:focus{
        opacity: .5;
    }

    .avatar-input-hint{
        visibility: hidden;
        font-size: 9px;
        font-weight: 700;
        line-height: 12px;
        text-transform: uppercase;
        margin: auto;
        color: white;
    }

    .avatar-input:hover .avatar-input-hint,
    .avatar-input:focus .avatar-input-hint{
        visibility: visible;
    }

    .file-input{
        position: absolute;
        width: 100px;
        height: 100px;
        opacity: 0;
    }
</style>