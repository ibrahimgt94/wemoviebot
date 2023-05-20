<?php

namespace lord\aps\panel\group\orgs;

use lord\plg\telg\view as telg_view;

class view extends telg_view
{
    public function show_gls(): string
    {
        return $this->text(
            "در این بخش شما می توانید دسته بندی جدید ایجاد کنید یا دسته بندی های موجود را مدیریت کنید"
        )->get();
    }

    public function search_gls(): string
    {
        return $this->text(
            "یکی از بخش های زیر را برای جستجوی در دسته بندی انتخاب کنید"
        )->get();
    }

    public function search_by_name_gls(): string
    {
        return $this->text(
            "برای جستجو با عنوان انگلیسی در دسته بندی ها لطفا بخشی از نام دسته بندی یا نام کامل آن را ارسال کنید"
        )->get();
    }

    public function search_by_name_proc_gls(): string
    {
        return $this->text(
            "لیست دسته بندی های های پیدا شده با متن درخواستی شما"
        )->get();
    }

    public function search_by_title_gls(): string
    {
        return $this->text(
            "برای جستجو با عنوان فارسی در دسته بندی ها لطفا بخشی از نام دسته بندی یا نام کامل آن را ارسال کنید"
        )->get();
    }

    public function search_by_title_proc_gls(): string
    {
        return $this->text(
            "لیست دسته بندی های های پیدا شده با متن درخواستی شما"
        )->get();
    }

    public function list_gls(): string
    {
        return $this->text(
            "لیستی از دسته بندی های موجود نمایش داده شده است برای مدیریت دسته بندی آن را انتخاب کنید"
        )->get();
    }

    public function list_chg_gls($group): string
    {
        return $this->text(
            "برای مدیریت دسته بندی موردنظر یکی از بخش های زیر را انتخاب کنید"
        )->param("عنوان دسته بندی", $group->title)
            ->param("وضعیت پرنت", $group->parent_title)
            ->param("وضعیت", $group->status ? "فعال" : "غیرفعال")->get();
    }

    public function edite_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید دسته بندی مورد نظر خود را ویرایش کنید."
        )->get();
    }

    public function delete_gls(): string
    {
        return $this->text(
            "در صورتی که از حذف دسته بندی مورد نظر اطمینان دارید روی دکمه حذف کن بزنید"
        )->get();
    }

    public function status_gls($gps_title, $gps_status): string
    {
        return $this->text(
            "در این بخش شما میتوانید وضعیت نمایش دسته بندی را تعیین کنید"
        )->param("دسته بندی", $gps_title)
            ->param("وضعیت دسته بندی", $gps_status ? "نمایش داده می شود" : "نمایش داده نمی شود")->get();
    }

    public function status_proc_gls($status, $type): string
    {
        $type = ($type == "yes" ? "فعال" : "غیرفعال");

        $text = ($status == true) ? (
            $this->text("وضعیت دسته بندی با موفقیت به {$type} تغییر پیدا کرد")
        ) : $this->text("خطا در تغییر وضعیت دسته بندی لطفا دوباره تلاش کنید");

        return $text->get();
    }

    public function parent_gls($gps_title): string
    {
        return $this->text(
            "دراین بخش شما میتوانید برای دسته بندی مورد نظر یک والد انتخاب کنید"
        )->param("والد کنونی", $gps_title)->get();
    }

    public function parent_proc_gls($status): string
    {
        $text = ($status == true) ? (
        $this->text("والد دسته بندی مورد نظر با موفقیت تغییر کرد")
        ) : $this->text("خطا در تغییر والد دسته بندی لطفا دوباره تلاش کنید");

        return $text->get();
    }

    public function delete_proc_gls($status): string
    {
        $text = ($status == true) ? (
        $this->text("حذف دسته بندی مورد نظر با موفقیت انجام شد")
        ) : $this->text("خطا در حذف دسته بندی لطفا دوباره تلاش کنید");

        return $text->get();
    }

    public function edite_name_gls($name): string
    {
        return $this->text(
            "برای ویرایش عنوان انگلیسی این دسته بندی لطفا عنوان جدید را ارسال کنید"
        )->param("عنوان انگلیسی فعلی", $name)->get();
    }

    public function edite_name_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("عنوان دسته بندی انگلیسی مورد نظر با موفقیت تغییر کرد")
        ) : $this->text("خطا در تغییر عنوان انگلیسی دسته بندی لطفا دوباره تلاش کنید");

        return $text->get();
    }

    public function edite_title_gls($title): string
    {
        return $this->text(
            "برای ویرایش عنوان فارسی این دسته بندی لطفا عنوان جدید را ارسال کنید"
        )->param("عنوان فارسی فعلی", $title)->get();
    }

    public function edite_title_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("عنوان دسته بندی فارسی مورد نظر با موفقیت تغییر کرد")
        ) : $this->text("خطا در تغییر عنوان فارسی دسته بندی لطفا دوباره تلاش کنید");

        return $text->get();
    }

    public function edite_desc_gls($name): string
    {
        return $this->text(
            "برای ویرایش توضیحات این دسته بندی لطفا توضیحات جدید را ارسال کنید"
        )->param("توضیحات فعلی", $name)->get();
    }

    public function edite_desc_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("توضیحات دسته بندی مورد نظر با موفقیت تغییر کرد")
        ) : $this->text("خطا در تغییر توضیحات دسته بندی لطفا دوباره تلاش کنید");

        return $text->get();
    }

    public function add_gls(): string
    {
        return $this->text(
            "برای افزودن دسته بندی جدید لطفا عنوان انگلیسی را برای دسته بندی ارسال کنید"
        )->get();
    }

    public function add_save_name_gls(): string
    {
        return $this->text(
            "در صورتی که متن ارسال مورد تایید است برای ادامه کار بر روی دکمه مرحله بعد بزنید"
        )->get();
    }

    public function add_save_title_gls(): string
    {
        return $this->text(
            "در صورتی که متن ارسال مورد تایید است برای ادامه کار بر روی دکمه مرحله بعد بزنید"
        )->get();
    }

    public function add_show_title_gls(): string
    {
        return $this->text(
            "لطفا عنوان فارسی برای این دسته بندی ارسال کنید"
        )->get();
    }

    public function add_show_desc_gls(): string
    {
        return $this->text(
            "لطفا توضیحات را برای این دسته بندی ارسال کنید"
        )->get();
    }

    public function add_save_desc_gls(): string
    {
        return $this->text(
            "در صورتی که متن ارسال مورد تایید است برای ادامه کار بر روی دکمه مرحله بعد بزنید"
        )->get();
    }

    public function add_parent_gls(): string
    {
        return $this->text(
            "در این بخش شما می توانید یه والد برای دسته بندی انتخاب کنید"
        )->get();
    }

    public function add_status_gls(): string
    {
        return $this->text(
            "لطفا وضعیت را برای این دسته بندی انتخاب کنید"
        )->get();
    }

    public function add_create_gls($data): string
    {
        $text = $this->text(
            "در صورتی که از تمام اطلاعت نمایش داد شده اطمینان دارید روی دکمه ساخت دسته بندی بزنید"
        );

        $datas = collect(json_decode($data, true));

        $datas->has("name") ?? (
            $text->param("عنوان انگلیسی", $datas->name)
        );

        $datas->has("title") ?? (
            $text->param("عنوان فارسی", $datas->get("title"))
        );

        $datas->has("desc") ?? (
            $text->param("توضیحات", $datas->get("desc"))
        );

        $datas->has("parent") ?? (
            $text->param("والد", (($datas->get("parent") == "nls") ? "والدی انتخاب نشده است" : $datas->get("parent")))
        );

        $datas->has("status") ?? (
            $text->param("وضعیت", $datas->get("status"))
        );

        return $text->get();
    }

    public function add_create_proc_gls($status): string
    {
        $text = ($status == true) ? (
            $this->text("دسته بندی با موفقیت ایجاد شد")
        ) : $this->text("خطا در ایجاد دسته بندی لطفا دوباره تلاش کنید");

        return $text->get();
    }
}