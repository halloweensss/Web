<?php

use yii\helpers\Html;

?>
<header>
        <nav class="navbar fixed-top navbar-light bg-white">
            <a class="navbar-brand" href="#">
                <img class="d-inline-block align-top icon-header" src="img/icon.svg">
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
                    <a class="name-profile" id="userName">Halloweens</a>
                    <img class="rounded-circle icon-profile" src="img/sand.jpg">
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUserInfo">
                    <a class="dropdown-item" href="settings.html">Настройки</a>
                    <a class="dropdown-item" href="login.html">Выйти</a>
                </div>
            </div>
        </nav>
    </header>