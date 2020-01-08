<template>
    <div>
        <vue-headful title="Обновление"/>
    <div class="login-container d-flex align-items-center justify-content-center">
        <form class="login-form" method="post" enctype="multipart/form-data" @submit.prevent="submitHandler">
            <div class="form-group">
                <template v-if="image == null">
                <div class="avatar-input rounded-circle" >
                    <div class="avatar-input-hint">Изменить аватар</div>
                    <input class="file-input" type="file" accept="image/*" @change="onFileChange">
                </div>
                </template>
                <template v-else-if="image != null">
                    <div class="avatar-input rounded-circle" :style="{'background-image': 'url('+imageSrc+')'}" >
                        <div class="avatar-input-hint">Изменить аватар</div>
                        <input class="file-input" type="file" accept="image/*" @change="onFileChange">
                    </div>
                </template>
            </div>
            <div class="form-group">
                <input id="login"
                       type="text"
                       v-model.trim="login"
                       :class="{invalid: ($v.login.$dirty && !$v.login.required) || ($v.login.$dirty && !$v.login.maxLength)}"
                       class="form-control input"
                       placeholder="Логин">
                <small
                        id="loginEmpty"
                        class="helper-text invalid"
                       v-if="$v.login.$dirty && !$v.login.required">
                    Поле не должно быть пустым
                </small>
                <small
                        id="loginLessCharacter"
                        class="helper-text invalid"
                       v-else-if="$v.login.$dirty && !$v.login.maxLength">
                    Логин должен быть меньше {{this.maxLengthLogin}} символов
                </small>
            </div>
            <div class="form-group">
                <input id="password"
                       type="password"
                       v-model.trim="password"
                       :class="{invalid: this.password.length > 0 && ($v.password.$dirty && !$v.password.minLength)}"
                       class="form-control input"
                       placeholder="Новый пароль">
                <small
                        id="passwordLessCharacter"
                        class="helper-text invalid"
                       v-if="(this.password.length > 0 && ( !$v.password.minLength))">
                    Пароль должен быть не менее {{this.minLengthPassword}} символов
                </small>
            </div>
            <div class="form-group">
                <input id="submit" type="submit" class="form-control input submit" value="Сохранить">
            </div>
            <router-link to="/">
                <a id="exit" href="index.html">Назад</a>
            </router-link>
        </form>
    </div>
    </div>
</template>

<script>
    import {HTTPData} from "../components/http";
    import {required, minLength, maxLength} from "vuelidate/lib/validators"
    export default {
        name: "Update",
        data() {
            return {
                login: '',
                password: '',
                minLengthPassword: 6,
                maxLengthLogin: 20,
                image: null,
                imageSrc: ''
            };
        },
        validations: {
            password : {minLength: minLength(6)},
            login: {required, maxLength:maxLength(20)}
        },
        created(){
            this.getProfileInfo();
        },
        methods:{
            updateInformationProfile(){
                const data = new FormData();
                data.append('accessToken', this.getCookie('accessToken'));
                data.append('password', this.password);
                data.append('login', this.login);
                data.append('avatarImage', this.image);
                HTTPData.post('/user/update',
                    data).then(
                    (response) => {
                        this.result = response.data.status;
                        if(this.result == 'success'){
                            this.$router.push('/update');
                        }
                    }).catch(error => {
                        console.log(error);
                });
            },
            getCookie(name){
                var results = document.cookie.match ( '(^|;) ?' + name + '=([^;]*)(;|$)' );
                if ( results )
                    return ( unescape ( results[2] ) );
                else
                    return null;
            },
            getProfileInfo(){
                const data = new FormData();
                data.append('accessToken', this.getCookie('accessToken'));
                HTTPData.post('/user/get-profile', data).then(
                    (response) => {
                        this.result = response.data.status;
                        if(this.result == 'success'){
                            this.login = response.data.user.username;
                            const imageData = response.data.user.image;
                            if(imageData != null) {
                                this.image = imageData;
                                this.imageSrc = 'data:image/jpg;base64,'+imageData;
                            }
                        }else{
                            if(this.result=='tokenInvalid') {
                                this.$router.push('/login');
                            }
                        }
                    },
                    (error) =>{
                        this.result = error.response.data;
                    }
                )
            },
            submitHandler(){
                if(this.$v.$invalid){
                    this.$v.$touch();
                    return;
                }
                this.updateInformationProfile();
            },
            onFileChange(event){
                const file = event.target.files[0];

                const reader = new FileReader();
                reader.onload = () => {
                    this.imageSrc = reader.result;
                };
                reader.readAsDataURL(file);
                this.image = file;
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