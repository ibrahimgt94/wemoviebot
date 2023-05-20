<?php

namespace lord\aps\panel\notice\orgs;

use lord\plg\telg\view as telg_view;

class view extends telg_view
{
    public function show_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("در این بخش شما میتوانید یک اطلاع رسانی جدید ایجاد کنید یا اطلاع رسانی های ایجاد شده را مدیریت کنید")->get();
    }

    public function delete_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("اگر از حذف این اطلاع رسانی اطمینان دارید روی دکمه حذف کن بزنید")->get();
    }

    public function delete_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("حذف این اطلاع رسانی با موفقیت انجام شد")
        ) : $this->text("خطا در حذف این اطلاع رسانی . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function wait_after_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("wait after norice")->get();
    }

    public function wait_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("در لیست زیر کاربرانی که در صف اطلاع رسانی هستند قابل مشاهده و مدیریت است")->get();
    }

    public function wait_search_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("برای جستجوی کاربر در این اطلاع رسانی لطفا بخشی یا نام کاربری کامل کاربر مورد نظر را ارسال کنید")
            ->text("نام کاربری ارسالی باید بین 5 تا 32 حرف و به حروف انگلیسی باشد")->get();
    }

    public function wait_show_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("با استفاده از دکمه های زیر می توانید این اطلاع رسانی را ارسال کرده یا این کاربر را از این اطلاع رسانی حذف کنید")->get();
    }

    public function wait_resend_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("در صورتی که ارسال این اطلاع رسانی اطمینان دارید روی دکمه ‍پیام اطلاع رسانی را ارسال کن بزنید")->get();
    }

    public function wait_resend_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("ارسال این اطلاع رسانی با موفقیت انجام شد")
        ) : $this->text("خطا در ارسال این اطلاع رسانی . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function wait_delete_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("در صورتی که از حذف این اطلاع رسانی اطمینان دارید روی دکمه ‍این پیام اطلاع رسانی از صف حذف کن بزنید")->get();
    }

    public function wait_delete_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("حذف این اطلاع رسانی با موفقیت انجام شد")
        ) : $this->text("خطا در حذف این اطلاع رسانی . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function add_title_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("لطفا متن ارسالی به کاربر که شامل حروف فارسی و بین 5 تا 255 حرف باشد ارسال کنید")->get();
    }

    public function add_body_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("لطفا وضعیت این اطلاع رسانی را انتخاب کنید  . در صورتی که وضعیت را غیرفعال انتخاب کنید هیچ پیامی به کاربر با این اطلاع رسانی ارسال نخواهد شد")
            ->get();
    }

    public function add_status_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("در صورتی که از متن های ارسالی اطمینان دارید می توانید با دکمه اطلاع رسانی را ذخیره کن این پیش نویس اطلاع رسانی را ذخیره کنید یا با بازگشت می توانید این پیش نویس اطلاع رسانی را حذف کنید")
            ->get();
    }

    public function add_save_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("ذخیره این اطلاع رسانی با موفقیت انجام شد")
        ) : $this->text("خطا در ذخیره این اطلاع رسانی . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function add_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("در این بخش شما میتوانید یه پیام اطلاع رسانی را ایجاد کنید")
            ->text("لطفا یک عنوان که شامل حروف فارسی و بین 5 تا 30 حرف باشد ارسال کنید")->get();
    }

    public function edit_gls(): string
    {
        return $this->text("اطلاع رسانی")
            ->text("در این بخش شما میتوانید این اطلاع رسانی را مدیریت کنی")->get();
    }

    public function edit_title_gls($title): string
    {
        return $this->text("اطلاع رسانی")
            ->text("در این بخش شما میتوانید یه عنوان برای این اطلاع رسانی انتخاب کنید")
            ->param("عنوان فعلی", $title)->get();
    }

    public function edit_title_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("ذخیره عنوان این اطلاع رسانی با موفقیت انجام شد")
        ) : $this->text("خطا در ذخیره عنوان این اطلاع رسانی . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function edit_body_gls($body): string
    {
        return $this->text("اطلاع رسانی")
            ->text("در این بخش شما میتوانید یه متن برای ارسال به کاربر برای این اطلاع رسانی انتخاب کنید")
            ->param("توضیحات فعلی", $body)->get();
    }

    public function edit_body_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("ذخیره متن ارسالی این اطلاع رسانی با موفقیت انجام شد")
        ) : $this->text("خطا در ذخیره متن ارسالی این اطلاع رسانی . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }

    public function edit_status_gls($status): string
    {
        return $this->text("اطلاع رسانی")
            ->text("در این بخش شما میتوانید وضعیت این اطلاع رسانی را انتخاب کنید . در صورتی که وضعیت به غیرفعال تغییر کند این اطلاع رسانی به هیچ کاربری ارسال نخواهد شد")
            ->param("وضعیت فعلی", ($status == true) ? (
                    "نمایش داده می شود"
                ) : "نمایش داده نمی شود"
            )->get();
    }

    public function edit_status_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("ویرایش وضعیت این اطلاع رسانی با موفقیت انجام شد")
        ) : $this->text("خطا در ویرایش وضعیت این اطلاع رسانی . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }
}