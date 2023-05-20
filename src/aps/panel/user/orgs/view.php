<?php

namespace lord\aps\panel\user\orgs;

use lord\dbs\user;
use lord\plg\telg\view as telg_view;

class view extends telg_view
{
    public function show_gls(): string
    {
        return $this->text(
            "در زیر می توانید لیست کاربرانی که در ربات ثبت نام کرده اند را مدیریت نمایید"
        )->text(
            " شما می توانید به تمام کاربران پیام ارسال کنید یا کاربری را با استفاده از نام کاربری یا ای دی جستجو کنید"
        )->get();
    }

    public function search_gls(): string
    {
        return $this->text(
            "برای جستجوی کاربر مورد نظر لطفا یکی از گزینه های زیر را انتخاب کنید"
        )->get();
    }

    public function search_id_gls(): string
    {
        return $this->text(
            "برای جستجوی کاربر لطفا بخشی یا ای دی کامل کاربر مورد نظر را ارسال کنید"
        )->get();
    }

    public function search_id_proc_gls(): string
    {
        return $this->text(
            "لیست کاربرانی که بر اساس متن جستجوی شما پیدا شد"
        )->get();
    }

    public function search_username_gls(): string
    {
        return $this->text(
            "برای جستجوی کاربر لطفا بخشی یا نام کاربری کامل کاربر مورد نظر را ارسال کنید"
        )->get();
    }

    public function search_username_proc_gls(): string
    {
        return $this->text(
            "لیست کاربرانی که بر اساس متن جستجوی شما پیدا شد"
        )->get();
    }

    public function coin_gls(int $coin_count): string
    {
        return $this->text("با استفاده از دکمه های زیر میتوانید سکه های کاربر مورد نظر را افزایش یا کاهش دهید")
            ->param("تعداد سکه های موجود کاربر", "{$coin_count} سکه ")->get();
    }

    public function info_gls($user): string
    {
        $messg = $this->text("مشخصات کاربر مورد نظر در زیر اوردن شده است");
        $messg->param("ای دی", $user->id);
        $messg->param("نام کاربری", $user->username);
        $messg->param("سکه ها", "{$user->coin} سکه ");
        $messg->param("تعداد زیرمجموعه", "{$user->subset} نفر ");
        $messg->param("وضعیت", $user->status ? "ازاد" : "مسدود شده");
        $messg->text("با استفاده از دکمه های زیر می توانید کاربر را مدیریت کنید");
        return $messg->get();
    }

    public function coin_among_gls(string $type): string
    {
        $text = ($type == "up") ? (
            "برای افزایش سکه های کاربر مورد نظر لطفا یکی از اعداد زیر را انتخاب کنید"
        ) : "برای کاهش سکه های کاربر مورد نظر لطفا یکی از اعداد زیر را انتخاب کنید";

        return $this->text($text)->get();
    }

    public function notice_gls(): string
    {
        return $this->text("برای ارسال اطلاع رسانی به این کاربر لطفا یکی از عنوان های مورد نظر را انتخاب کنید.")->get();
    }

    public function notice_all_gls(): string
    {
        return $this->text(
            "برای ارسال اطلاع رسانی به این کاربر لطفا یکی از عنوان های مورد نظر را انتخاب کنید."
        )->get();
    }

    public function notice_all_chg_gls($notic): string
    {
        return $this->text(
            "اگر از اطلاع رسانی این پیام به کاربران مورد نظر اطمینان دارید روی دکمه ارسال کن بزنید تا پیام برای کاربران مورد نظر ارسال شود"
        )->param("عنوان", $notic->title)->text($notic->body)->get();
    }

    public function notice_proc_gls(): string
    {
        return $this->text(
            "پیام اطلاع رسانی مورد نظر در صف ارسال قرار گرفت و به زودی برای کاربران ارسال خواهد شد"
        )->text(
            "برای مشاهده امار ارسال پیام همگانی به بخش اطلاع رسانی همگانی مراجعه کنید"
        )->get();
    }

    public function notice_chg_gls($notic): string
    {
        return $this->text(
            "اگر از اطلاع رسانی این پیام به کاربر مورد نظر اطمینان دارید روی دکمه ارسال کن بزنید تا پیام برای کاربر مورد نظر ارسال شود"
        )->param("عنوان", $notic->title)->text($notic->body)->get();
    }

    public function status_gls(): string
    {
        return $this->text("با استفاده از دکمه های زیر می توانید کاربر را از استفاده کردن از ربات ازاد یا مسدود کنید")->get();
    }

    public function status_enable_gls(): string
    {
        return $this->text("کاربر مورد نظر با موفقیت آزاد شد")->get();
    }

    public function status_disable_gls(): string
    {
        return $this->text("کاربر مورد نظر با موفقیت مسدود شد.")->get();
    }

    public function coin_proc_gls(string $type, int $coin): string
    {
        $type = ($type == "up") ? "افزایش" : "کاهش";

        return $this->text(" موجودی سکه کاربر مورد نظر با موفقیت {$type} یافت")
            ->param("تعداد سکه های {$type} یافه کاربر", "{$coin} سکه ")->get();
    }

    public function delete_proc_gls(string $status)
    {
        $text = ($status == true) ? (
            "کاربر موردنظر با موفقیت حذف شد"
        ) : "خطا در حذف کاربر مورد نظر لطفا دوباره تلاش کنید";

       return $this->text($text)->get();
    }
}