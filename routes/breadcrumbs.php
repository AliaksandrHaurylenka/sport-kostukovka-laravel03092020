<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Crumbs;
// use App\Entity\User;

Breadcrumbs::register('main', function (Crumbs $crumbs) {
    $crumbs->push('Главная', route('main'));
});

Breadcrumbs::register('uslugi', function (Crumbs $crumbs) {
    $crumbs->parent('main');
    $crumbs->push('Услуги', route('uslugi'));
});
Breadcrumbs::register('kostyukovskie-luzhniki', function (Crumbs $crumbs) {
    $crumbs->parent('main');
    $crumbs->push('Костюковские Лужники');
});
Breadcrumbs::register('novosti', function (Crumbs $crumbs) {
    $crumbs->parent('main');
    $crumbs->push('Новости', route('novosti'));
});
Breadcrumbs::register('category.show', function (Crumbs $crumbs, $section) {
    $crumbs->parent('novosti');
    $crumbs->push($section->title, route('category.show', $section->slug));
});
Breadcrumbs::register('tag.show', function (Crumbs $crumbs, $tag_title) {
    $crumbs->parent('novosti');
    $crumbs->push($tag_title->title);
});
Breadcrumbs::register('year', function (Crumbs $crumbs, $year) {
    $crumbs->parent('novosti');
    $crumbs->push($year);
});
Breadcrumbs::register('user_name', function (Crumbs $crumbs, $user_name) {
    $crumbs->parent('novosti');
    $crumbs->push($user_name->name);
});
Breadcrumbs::register('no-category.show', function (Crumbs $crumbs) {
    $crumbs->parent('novosti');
    $crumbs->push('Без категории', route('no-category.show'));
});
Breadcrumbs::register('post.show', function (Crumbs $crumbs, $section, $post) {
    if($section){
        $crumbs->parent('category.show', $section);
        $crumbs->push($post->title);
    }
    else {
        $crumbs->parent('no-category.show');
        $crumbs->push($post->title);
    }  
});