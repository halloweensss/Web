<template>
  <div>
      <vue-headful title="Главная"/>
  <header>
    <nav class="navbar fixed-top navbar-light bg-white">
      <a class="navbar-brand" href="#">
        <img class="d-inline-block align-top icon-header" src="../assets/img/icon.svg">
      </a>
      <div class="d-flex mr-auto buttons-header">
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="pills-news-tab" data-toggle="pill" href="#pills-news" role="tab" aria-controls="pills-news" aria-selected="true">
              Новости
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-follow-tab" data-toggle="pill" href="#pills-follow" role="tab" aria-controls="pills-follow" aria-selected="false">
              Подписки
            </a>
          </li>
        </ul>
      </div>
      <div class="dropdown dropdown-header">
        <button class="d-flex btn dropdown-header shadow-none" type="button" id="dropdownUserInfo" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <a class="name-profile" id="userName">{{this.userInformation.username}}</a>
          <img class="rounded-circle icon-profile avatar-input" :style="{'background-image': 'url('+this.userInformation.avatarUrl+')'}">
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUserInfo">
          <router-link to="/update">
            <a id="settings" class="dropdown-item" href="">Настройки</a>
          </router-link>
          <router-link to="/login">
            <a id="exit" class="dropdown-item" @click="exit" href="">Выйти</a>
          </router-link>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-news" role="tabpanel" aria-labelledby="pills-news-tab">
        <template v-if="Object.keys(this.usersInfo).length > 0">
        <div v-masonry="" id="masonry-container" class="container">
          <Post v-for="(userInfo, index) in usersInfo" :key="'post' + index" v-bind:user-info="userInfo"/>
        </div>
        </template>
        <template v-else-if="(this.usersInfo).length == 0 && this.alreadyFollowUsers['status'] !== 'null'">
            <PostLoader></PostLoader>
        </template>
        <template v-else-if="this.alreadyFollowUsers['status'] === 'null'">
          <div class="text-follow-none">Список Ваших подписок пуст</div>
        </template>
      </div>
      <div class="tab-pane fade show" id="pills-follow" role="tabpanel" aria-labelledby="pills-follow-tab">
        <div class="container">
          <div class="col-12 d-flex flex-wrap p-0">
            <input class="form-control search-input" type="search" v-model.trim="searchNickname" placeholder="Поиск" id="SuggestionInput" aria-label="Search" @focusin="displayShow" @input="findFollowsThrottled" @focusout="displayNone">
          </div>
        </div>
        <div class="container">
          <div class="col-12">
            <div v-bind:style="{ display: this.display}" @click="displayNone" class="suggestion-container-items">
              <FollowCard v-for="(followUser, index) in followUsers" :key="followUser.serviceName + index" v-bind:follow-user="followUser" v-on:follow-update="followUpdate" v-on:unfollow-update="followUpdate"/>
            </div>
          </div>
        </div>
        <div class="container follow-container">
          <div class="col-12 d-flex flex-wrap align-items-center justify-content-center p-0">
            <div class="follow-container-items">
              <template v-if = "alreadyFollowUsers.length > 0">
              <AlreadyFollowCard v-for="(alreadyFollowUser, index) in alreadyFollowUsers" :key="alreadyFollowUser.serviceName + index" v-bind:already-follow-user="alreadyFollowUser" v-on:follow-update="followUpdate" v-on:unfollow-update="followUpdate"/>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  </div>
</template>
<script>
  import Post from "../components/Post";
  import FollowCard from "../components/FollowCard";
  import AlreadyFollowCard from "../components/AlreadyFollowCard";
  import PostLoader from "../components/PostLoader";
  import HTTP, {HTTPData} from "../components/http";
  import _ from 'lodash'

  export default {
    components: {PostLoader, AlreadyFollowCard, FollowCard, Post},
    data(){
      return{
        display: "none",
        searchNickname:'',
        userInformation:{
          avatarUrl:'/img/sand.1136b49a.jpg',
          username:''
        },
        usersInfo:[
        ],
        followUsers: [
        ],
        alreadyFollowUsers: [
        ]
      }
    },
    created(){
      this.getProfileInfo();
      this.getPosts();
      this.getFollows();
    },
    methods:{
      followUpdate(){
        this.getFollows();
        this.getPosts();
        this.findFollows();
        this.updateGrid();
      },
      findFollowsThrottled: _.throttle(function () {
        this.findFollows();
      },2000),
      findFollows: function(){
        HTTP.post('/user/get-followers-not-exist', {
          accessToken: this.getCookie('accessToken'),
          name: this.searchNickname
        }).then(
                (response) => {
                  if(response.data == null) {
                    this.followUsers = null;
                  }
                  else {
                    this.followUsers = response.data;
                  }
                },
                (error) =>{
                  this.result = error.response.data;
                }
        )
      },
      getCookie(name){
        var results = document.cookie.match ( '(^|;) ?' + name + '=([^;]*)(;|$)' );
        if ( results )
          return ( unescape ( results[2] ) );
        else
          return null;
      },
      exit(){
        document.cookie = "accessToken=";
        this.$router.push('/login');
      },
      getFollows(){
        HTTP.post('/user/get-followers-exist', {
          accessToken: this.getCookie('accessToken')
        }).then(
                (response) => {
                  if(response.data == null) {
                    this.alreadyFollowUsers = null;
                  }
                  else {
                    this.alreadyFollowUsers = response.data;
                  }
                },
                (error) =>{
                  this.result = error.response.data;
                }
        )
      },
      getProfileInfo(){
        const data = new FormData();
        data.append('accessToken', this.getCookie('accessToken'));
        HTTPData.post('/user/get-profile', data).then(
                (response) => {
                  this.result = response.data.status;
                  if(this.result == 'success'){
                    this.userInformation.username = response.data.user.username;
                    const imageData = response.data.user.image;
                    if(imageData != null) {
                      this.userInformation.avatarUrl  = 'data:image/jpg;base64,'+imageData;
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
      updateGrid(){
        if (typeof this.$redrawVueMasonry === 'function') {
          this.$redrawVueMasonry()
        }
      },
      getPosts() {
        HTTP.post('/post/get', {
          accessToken: this.getCookie('accessToken')
        }).then(
                (response) => {
                  this.usersInfo = response.data;
                },
                (error) => {
                  this.result = error.response.data;
                }
        )
      },
      displayNone: function () {
        setTimeout(()=>{this.display='none'},100);
      },
      displayShow: function () {
        this.display='block';
      }
    },
    mounted() {
      if (typeof this.$redrawVueMasonry === 'function') {
        this.$redrawVueMasonry()
      }
    }
  }
</script>
<style>

  a{
    text-decoration: none;
  }

  html{
    font-size: 16px;
  }

  hr{
    margin-top: 0px;
    color: #000000;
  }

  .avatar-input{
    background-image: url("../assets/img/sand.jpg");
    background-position: center;
    background-size: 100% 100%;
    width: 100px;
    height: 100px;
    display: flex;
    margin: auto;
  }

  .name-profile{
    margin-right: 5px;
    font-size: 20px;
  }

  .nav-link{
    color: #000000;
    opacity: .6;
  }
  .nav-link:hover,
  .nav-link:focus{
    color: #002EFF;
  }

  .nav-pills .nav-link{
    border-radius: 10px;
  }

  .nav-pills .nav-link.active, .nav-pills .show>.nav-link{
    background-color: #FFFFFF;
    color: #002EFF;
    opacity: 1;
  }

  @media only screen and (max-width : 768px) {
    .nav-pills {
      font-size: 14px;
    }
  }

  @media only screen and (max-width : 768px) {
    .nav-link {
      padding: .1rem .4rem;
    }
  }

  @media only screen and (max-width : 768px) {
    .name-profile {
      display: none;
    }
  }

  .dropdown-header{
    margin-left: 10px;
    padding: 0px;
  }

  .dropdown-header:hover,
  .dropdown-header:focus{
    color: #002EFF;
  }

  .icon-header{
    width: 32px;
    height: 32px;
    max-width: 32px;
    max-height: 32px;
  }

  .icon-profile{
    width: 32px;
    height: 32px;
    max-width: 32px;
    max-height: 32px;
  }

  .dropdown-menu{
    border: none;
  }
  .post{
    background-color: #ffffff;
    border: none;
    border-radius: 10px;
    margin-bottom: 10px;
  }

  .post-header{
    display: flex;
    justify-content: space-between;
    padding: 10px 15px;
  }

  .post-body{
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    padding: 10px 15px;
  }

  .post-footer{
    display: flex;
    flex-direction: row;
    padding-left: 15px;
    padding-right: 15px;
  }

  .post-footer-content{
    display: flex;
    flex-direction: row;
    font-size: 24px;
    opacity: .5;
  }

  .post-footer-date{
    vertical-align: center;
    font-size: 10px;
    display: flex;
    flex-direction: row;
    opacity: .5;
  }
  .post-footer-icon{
    font-size: 20px;
    margin-right: 5px;
  }

  .post-footer-action{
    color:#000000;
    text-decoration: none;
    padding-right: 10px;
  }

  .post-footer-action.retweet:hover,
  .post-footer-action:focus{
    text-decoration: none;
    color: #2196F3;
  }
  .post-footer-action:hover,
  .post-footer-action:focus{
    text-decoration: none;
    color: #F86C6C;
  }

  .post-footer-text{
    font-size: 12px;
  }

  .post-text{
    font-size: 1.0625rem;
    line-height: 1.625rem;
    font-weight: 400;
    height: 100%;
    word-break: break-all;
  }
  .carousel-control-prev,
  .carousel-control-next{
    margin-top: 130px;
    margin-bottom: 70px;
  }
  .post-body-content{
    margin-top: 10px;
    align-items: center;
    overflow: hidden;
    border-radius: 5px;
  }

  .container{
    padding-right: 0px;
    padding-left: 0px;
  }

  .no-padding{
    padding-left: 5px;
    padding-right: 5px;
  }

  @media only screen and (max-width : 768px) {
    .no-padding {
      padding-left: 0px;
      padding-right: 0px;
    }
  }

  .post-body-content-center{
    width: 100%;
    justify-content: center;
    align-items: center;
  }

  .service-img{
    color: #000000;
    font-size: 32px;
    width: 32px;
    opacity: .3;
  }

  .service-img.twitter:hover,
  .service-img.twitter:focus{
    color: #2168F3;
    opacity: .6;
  }

  .service-img.telegram:hover,
  .service-img.telegram:focus{
    color: #2168F3;
    opacity: .6;
  }

  .service-img.instagram:hover,
  .service-img.instagram:focus{
    color: #F32159;
    opacity: .6;
  }

  .avatar-img{
    width: 32px;
    height: 32px;
    overflow: hidden;
    border-radius: 50%;
  }

  .avatar{
    margin-right: 7px;
  }

  .account{
    display: flex;
    flex-direction: column;
  }

  .account-name{
    font-weight: 500;
    color: #000000;
  }

  .account-login{
    font-size: .8rem;
    margin-top: -6px;
    color: #000000;
    opacity: .6;
  }

  .account-login:hover,
  .account-login:focus{
    text-decoration: none;
  }
  .profile{
    display: flex;
    align-items: center;
    overflow: hidden;
  }
  .dropdown-item{
    opacity: .7;
  }

  .dropdown-item:hover,
  .dropdown-item:focus{
    border-radius: 5px;
    color: #002EFF;
    background-color: #FFFFFF;
    text-decoration: rgba(0,0,0,0);
  }
  .ml-50px{
    margin-left: 50px;
  }

  .follow-container{
    overflow: hidden;
    background-color: #FFFFFF;
    border-radius: 0px 0px 10px 10px;
  }

  .buttons-header{
    margin-left: 10px;
  }

  @media screen and (max-width : 768px) {
    .buttons-header {
      margin: auto;
    }
  }


  @media only screen and (max-width : 300px) {
    .nav-pills {
      font-size: 10px;
    }

    .icon-profile {
      width: 24px;
      height: 24px;
    }

    .icon-header {
      width: 24px;
      height: 24px;
    }
  }
  .search-input{
    font-size: 15px;
    border-radius: 10px 10px 0px 0px;
    background-color: #FFFFFF;
    border-color: #FBFBFB;
    border-bottom-color: #F1F1F1;
    opacity: 1;
  }

  .search-input:focus {
    background-color: #FAFAFA;
    border-color: #2168F3;
    border-bottom-color: #FAFAFA;
    box-shadow: none;
  }

  .follow-nickname{
    color: black;
    max-width: 50vw;
    overflow: hidden;
    text-overflow: ellipsis;
    margin: auto 20px;
    font-weight: 500;
    font-size: 16px;
    opacity: .6;
  }


  .follow-nickname:hover,
  .follow-nickname:focus{
    color: #2168F3;
    text-decoration: none;

  }

  .follow-card{
    width: 100%;
  }

  .follow-card:hover{
    background-color: #E0E6FF;
    text-decoration: none;
  }

  .follow-card:hover .service-img.twitter{
    color: #2168F3;
    opacity: .6;
  }

  .follow-card:hover .service-img.telegram{
    color: #2168F3;
    opacity: .6;
  }

  .follow-card:hover .service-img.instagram{
    color: #F32159;
    opacity: .6;
  }

  .follow-card:hover .follow-nickname{
    color: #2168F3;
    text-decoration: none;
  }

  .follow-card-margin{
    width: 100%;
    margin: 10px 40px;
  }


  @media only screen and (max-width : 768px) {
    .follow-nickname {
      max-width: 43vw;
    }
    .follow-card-margin{
      width: 100%;
      margin: 10px 10px;
    }
  }

  @media only screen and (max-width : 400px) {
    .follow-nickname {
      max-width: 34vw;
    }
  }


  @media only screen and (max-width : 300px) {
    .follow-nickname {
      max-width: 30vw;
    }
  }

  .suggestion-container-items {
    position: absolute;
    left: 0;
    z-index: 1000;
    float: left;
    min-width: 10rem;
    width: 100%;
    max-height: 70vh;
    overflow: auto;
    font-size: 1rem;
    text-align: left;
    background-color: #FBFBFB;
    border-bottom: 1px solid #2168F3;
    border-right: 1px solid #2168F3;
    border-left: 1px solid #2168F3;
    border-radius: 0 0 10px 10px;
    display: none;
  }

  .follow-button{
    margin: auto 0 auto auto;
    border-radius: 7px;
    height: 36px;
    padding: 2px 8px;
  }

  .follow-button.min{
    padding: 5px 10px;
    display: none;
  }

  .follow-container-items{
    max-height: 80vh;
    width: 100%;
    overflow: auto;
  }
  @media only screen and (max-width : 300px) {
    .follow-button {
      display: none;
    }
    .follow-button.min {
      display: flex;
    }
  }
  body{
    width: 100vw;
    height: 100vh;
    background-color: #EDF0FA;
    font-family: 'Roboto', sans-serif;
  }

  main{
    padding-top: 80px;
  }

  .text-follow-none{
    color:#000000;
    text-decoration: none;
    opacity: 0.5;
    text-align: center;
    display: block;
    margin: auto;
  }

</style>
