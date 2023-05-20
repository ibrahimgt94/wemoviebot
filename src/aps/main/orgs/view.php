<?php

namespace lord\aps\main\orgs;

use lord\plg\telg\view as telg_view;

class view extends telg_view
{
    public function show_cmd(): string
    {
        return $this->text("سلام به ربات ما خوش آمدید")
            ->text("در این ربات ما لیست فیلم های قدیمی ایرانی را برای شما گردآوری کرده ایم")
            ->get();
    }

    public function down_gls($movie, $propertys): string
    {
        $text = $this->title("اطلاعات فیلم")
            ->info($movie->image);

        collect($propertys)->each(function ($vals) use ($text) {
            $text->param($vals->title, $vals->data);
        });

        return $text->get();
    }

    public function support_gls($text): string
    {
        return $this->text("پشتیبانی ربات")->text($text)->get();
    }

    public function help_gls($text): string
    {
        return $this->text("راهنمای ربات")->text($text)->get();
    }

    public function profile_gls($bot_id, $profile): string
    {
        $subset_link = "\n\nhttps://t.me/{$bot_id}?start={$profile->id}";

        return $this->text("پروفایل")->text(
            "اطلاعات شما "
        )->param("ای دی شما", $profile->id)
            ->param("نام کاربری", $profile->username)
            ->param("تعداد سکه ها", "{$profile->coin} سکه ")
            ->param("تعداد زیرمجموعه های شما", "{$profile->subset} نفر ")
            ->param("لینک زیر مجموعه گیری", $subset_link)->get();
    }

    public function movie_gls($title): string
    {
        return $this->text("دسته بندی")
            ->param("دسته بندی پرنت", $title)->text(
                "لطفا یکی از فیلم های زیر را انتخاب کنید"
            )->get();
    }

    public function group_gls($args): string
    {
        return $this->text("دسته بندی")
            ->param("دسته بندی پرنت", $args->title)->text(
                "لطفا یکی از زیر مجموعه های زیر را انتخاب کنید"
            )->get();
    }

    public function search_gls(): string
    {
        return $this->title("جستجوی فیلم")
            ->text("لطفا نام فیلم مورد نظر خود را برای جستجو ارسال کنید")->get();
    }

    public function search_proc_gls(): string
    {
        return $this->title("جستجوی فیلم")
            ->text("لیست فیلم های موجود بر اساس متن ارسالی شما")->get();
    }
}