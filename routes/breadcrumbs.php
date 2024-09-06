<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Anasayfa
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Mağaza Sayfası
Breadcrumbs::for('shop', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Shop', route('shop'));
});

// Mağaza Listesi
Breadcrumbs::for('employee', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Employee',route('employee'));
});

Breadcrumbs::for('favory', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Favory', route('favory'));
});
