<?php

namespace lord\aps\panel\cog\orgs;

use lord\plg\telg\view as telg_view;

class view extends telg_view
{
    public function show_gls(): string
    {
        return $this->text("تنظیمات ربات")
            ->text("در این بخش تنظیمات ربات را می توانید مدیریت کنید")->get();
    }

    public function downs_gls(): string
    {
        return $this->text("تنظیمات ربات")
            ->text("در این بخش تنظیمات لینک های دانلود و اپلود قابل مدیریت است")->get();
    }

    public function down_uploadboy_gls($info_down): string
    {
        return $this->text("تنظیمات ربات")
            ->param("سرور", "\n{$info_down->server}")
            ->param("نام کاربری", "\n{$info_down->username}")
            ->param("پسورد", "\n{$info_down->password}")
            ->text(
                "در این بخش تنظیمات سرور اف تی پی شرکت اپلود بوی قابل مدیریت است"
            )->get();
    }

    public function down_uploadboy_username_gls($user): string
    {
        return $this->text("تنظیمات ربات")
            ->text("لطفا نام کاربری سرور اف تی پی اپلود بوی را ارسال کنید")
            ->param("نام کاربری فعلی", $user)->get();
    }

    public function down_uploadboy_username_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("نام کاربری سرور اف تی پی اپلود بوی با موفقیت تغییر یافت")
        ) : $this->text("خطا در ابدیت نام کاربری اف تی پی سرور اپلود بوی . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function down_uploadboy_password_gls($pass): string
    {
        return $this->text("تنظیمات ربات")
            ->text("لطفا پسورد سرور اف تی پی اپلود بوی را ارسال کنید")
            ->param("پسورد فعلی", $pass)->get();
    }

    public function down_uploadboy_password_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("پسورد سرور اف تی پی اپلود بوی با موفقیت تغییر یافت")
        ) : $this->text("خطا در ابدیت پسورد اف تی پی سرور اپلود بوی . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function down_ftp_gls($info_down): string
    {
        return $this->text("تنظیمات ربات")
            ->param("سرور", "\n{$info_down->server}")
            ->param("نام کاربری", "\n{$info_down->username}")
            ->param("پسورد", "\n{$info_down->password}")
            ->text(
                "در این بخش تنظیمات سرور اف تی پی هاست دانلود قابل مدیریت است"
            )->get();
    }

    public function down_ftp_server_gls($server): string
    {
        return $this->text("تنظیمات ربات")
            ->text("لطفا آدرس هاست سرور اف تی پی هاست دانلود را ارسال کنید")
            ->param("آدرس هاست فعلی", $server)->get();
    }

    public function down_ftp_server_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("آدرس هاست سرور اف تی پی هاست دانلود با موفقیت تغییر یافت")
        ) : $this->text("خطا در ابدیت آدرس هاست اف تی پی سرور هاست دانلود . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function down_ftp_username_gls($user): string
    {
        return $this->text("تنظیمات ربات")
            ->text("لطفا نام کاربری سرور اف تی پی هاست دانلود را ارسال کنید")
            ->param("نام کاربری فعلی", $user)->get();
    }

    public function down_ftp_username_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("نام کاربری سرور اف تی پی هاست دانلود با موفقیت تغییر یافت")
        ) : $this->text("خطا در ابدیت نام کاربری اف تی پی سرور هاست دانلود . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function down_ftp_password_gls($pass): string
    {
        return $this->text("تنظیمات ربات")
            ->text("لطفا پسورد سرور اف تی پی هاست دانلود را ارسال کنید")
            ->param("پسورد فعلی", $pass)->get();
    }

    public function down_ftp_password_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("پسورد سرور اف تی پی هاست دانلود با موفقیت تغییر یافت")
        ) : $this->text("خطا در ابدیت پسورد اف تی پی سرور هاست دانلود . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function down_telegram_gls($info_chanel): string
    {
        return $this->text("تنظیمات ربات")
            ->param("کانال بکاپ", $info_chanel)
            ->text("در این بخش کانال تلگرامی را برای اپلود فیلم ها در این کانال برای بکاپ گیری از فیلم ها ارسال کنید")->get();
    }

    public function down_uploadboy_server_gls(): string
    {
        return $this->text("تنظیمات ربات")->text(
                "در این بخش می توانید سرور شرکت اپلود بوی را برای اپلود فیلم ها انتخاب کنید"
            )->get();
    }

    public function down_telegram_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("کانال تلگرامی با موفقیت تغییر یافت")
        ) : $this->text("خطا در ابدیت کانال تلگرام . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function support_gls($support): string
    {
        return $this->text("تنظیمات ربات")->text(
            "در این بخش متن پشتیبانی که در صفحه اصلی قابل مشاهده است قابل مدیرت است"
        )->param("متن پشتیبانی", $support)->get();
    }

    public function support_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("متن پشتیبانی با موفقیت تغییر یافت")
        ) : $this->text("خطا در ابدیت متن پشتیبانی . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function help_gls($help): string
    {
        return $this->text("تنظیمات ربات")->text(
            "در این بخش متن راهنما که در صفحه اصلی قابل مشاهده است قابل مدیرت است"
        )->param("متن راهنما", $help)->get();
    }

    public function help_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("متن راهنما با موفقیت تغییر یافت")
        ) : $this->text("خطا در ابدیت متن راهنما . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function status_gls($status): string
    {
        return $this->text("تنظیمات ربات")
            ->text("در این بخش می توانید وضعیت ربات را مدیریت کنید")
            ->param("وضعیت فعلی", $status ? "ربات فعال است" : "ربات غیرفعال است")->get();
    }

    public function status_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("وضعیت ربات با موفقیت تغییر یافت")
        ) : $this->text("خطا در ابدیت وضعیت ابدیت . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function chunk_gls(): string
    {
        return $this->text("تنظیمات ربات")->text(
            "در این بخش شما می توانید تعداد دکمه ها در هر صفحه و همچنین تعداد دکمه ها در یک سطر را مدیریت کنید"
        )->get();
    }

    public function chunk_rows_gls(): string
    {
        return $this->text("تنظیمات ربات")->text(
            "در این بخش می توانید تعداد دکمه ها در یک سطر را مدیریت کنید"
        )->get();
    }

    public function chunk_take_gls(): string
    {
        return $this->text("تنظیمات ربات")->text(
            "در این بخش می توانید تعداد دکمه ها در صفحه را مدیریت کنید"
        )->get();
    }

    public function channel_gls(): string
    {
        return $this->text("تنظیمات ربات")->text(
            "در این بخش شما میتوانید لینک های خارجی صفحه اول را مدیریت کنید"
        )->get();
    }

    public function subset_gls(): string
    {
        return $this->text("تنظیمات ربات")->text(
            "در این بخش شما میتوانید تنظیمات زیر مجموعه گیری را مدیریت کنید"
        )->get();
    }

    public function group_gls(): string
    {
        return $this->text("تنظیمات ربات")->text(
            "در این بخش شما میتوانید دسته بندی های که می خواهید در صفحه اول نمایش داده شود را مدیریت کنید"
        )->get();
    }

    public function channel_after_gls($chanel): string
    {
        return $this->text("تنظیمات ربات")->text(
            "برای ویرایش عنوان و ادرس دکمه های صفحه اصلی "
        )->param("عنوان", urldecode($chanel->get("title")))
            ->param("آدرس", "\n".$chanel->get("url"))
            ->param("وضعیت", $chanel->get("status") ? "نمایش داده می شود" : "نمایش داده نمیشود")->get();
    }

    public function channel_title_gls(): string
    {
        return $this->text("تنظیمات ربات")->text(
            "لطفا یک عنوان برای این کانال ارسال کنید"
        )->get();
    }

    public function channel_title_proc_gls($status, $ch_type): string
    {
        $text = ($status == true) ? (
            $this->text("متن عنوان کانال {$ch_type} با موفقیت تغییر یافت")
        ) : $this->text("خطا در ابدیت متن عنوان کانال {$ch_type} . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function channel_ps_gls(): string
    {
        return $this->text("تنظیمات ربات")->text(
            "لطفا آدرس مورد نظر را ارسال کنید"
        )->get();
    }

    public function channel_ps_proc_gls($status, $ch_type): string
    {
        $text = ($status == true) ? (
            $this->text("آدرس کانال {$ch_type} با موفقیت تغییر یافت")
        ) : $this->text("خطا در ابدیت آدرس کانال {$ch_type} . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }
}