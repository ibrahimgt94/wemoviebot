<?php

namespace lord\aps\panel\movie\orgs;

use lord\plg\telg\view as telg_view;

class view extends telg_view
{
    use add_view;

    public function show_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید فیلم های موجود را مدیریت یا یک فیلم جدید اضافه کنید"
        )->get();
    }

    public function search_gls(): string
    {
        return $this->text(
            "لطفا عنوان فیلم مورد نظر را ارسال کنید"
        )->get();
    }

    public function search_proc_gls(): string
    {
        return $this->text(
            "لیست فیلم های موجود برای جستجوی شما"
        )->get();
    }

    public function list_gls(): string
    {
        return $this->text(
            "لیست فیلم های موجود در این بخش نمایش داده می شود"
        )->get();
    }

    public function sendsite_gls(): string
    {
        return $this->text(
            "ارسال به سایت به زودی تکمیل می شود"
        )->get();
    }


    public function sendchannel_gls(): string
    {
        return $this->text(
            "پست با موفقیت به کانال ارسال شد"
        )->get();
    }


    public function list_show_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید فیلم مورد نظر را ویرایش کنید"
        )->get();
    }

    public function title_gls($title): string
    {
        return $this->text(
            "عنوان فیلم مورد نظر را به فارسی ارسال کنید"
        )->param("عنوان فعلی", $title)->get();
    }

    public function title_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش عنوان ویدئو");

        $proc_status ? (
            $text->text("عنوان ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ابدیت عنوان ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function image_gls(): string
    {
        return $this->text(
            "برای ویرایش تصویر فیلم مورد نظر لطفا یه تصویر ارسال کنید"
        )->get();
    }

    public function image_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش تصویر ویدئو");

        $proc_status ? (
            $text->text("تصویر ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ابدیت تصویر ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function summary_gls($summary): string
    {
        return $this->text(
            "برای ویرایش خلاصه فیلم مورد نظر لطفا متن خلاصه فیلم را ارسال کنید"
        )->param("خلاصه فعلی", $summary)->get();
    }

    public function summary_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش خلاصه ویدئو");

        $proc_status ? (
            $text->text("خلاصه ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ابدیت خلاصه ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function down_delete_gls(): string
    {
        return $this->text(
            "در صورتی که تمایل دارید این لینک را حذف کنید روی حذف کن بزنید"
        )->get();
    }

    public function down_delete_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش لینک های دانلود ویدئو");

        $proc_status ? (
            $text->text("لینک دانلود با موفقیت حذف شد")
        ) : $text->text("خطا در حذف لینک دانلود ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function status_gls($status): string
    {
        return $this->text(
            "یکی از وضعیت ها زیر را برای نمایش یا عدم نمایش پست در صفحه اصلی انتخاب کنید"
        )->param("وضعیت فعلی", $status)->get();
    }

    public function status_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش وضعیت ویدئو");

        $proc_status ? (
            $text->text("وضعیت ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ابدیت وضعیت ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function down_gls(): string
    {
        return $this->text(
            "در این بخش شما می توانید لینک های فیلم مورد نظر را مدیریت کنید"
        )->get();
    }

    public function property_gls(): string
    {
        return $this->text(
            "در این بخش شما می توانید خصوصیات و اطلاعات فیلم خود را انتخاب کنید"
        )->get();
    }

    public function director_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند کارگردان برای این فیلم انتخاب کنید"
        )->get();
    }

    public function producer_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند تهیه کننده برای این فیلم انتخاب کنید"
        )->get();
    }

    public function writer_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند نویسنده برای این فیلم انتخاب کنید"
        )->get();
    }

    public function actors_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند بازیگر برای این فیلم انتخاب کنید"
        )->get();
    }

    public function asong_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند اهنگساز برای این فیلم انتخاب کنید"
        )->get();
    }

    public function singer_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند خواننده برای این فیلم انتخاب کنید"
        )->get();
    }

    public function filming_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید مدیر فیلم برداری برای این فیلم انتخاب کنید"
        )->get();
    }

    public function year_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید سال تولید این فیلم انتخاب کنید"
        )->get();
    }

    public function duration_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید مدت زمان این فیلم انتخاب کنید"
        )->get();
    }

    public function down_add_addr_gls(): string
    {
        return $this->text(
            "لطفا نوع لینک مورد نظر را انتخاب کنید"
        )->get();
    }

    public function down_add_addr_two_gls(): string
    {
        return $this->text(
            "لطفا لینک فیلم مورد نظر را ارسال کنید"
        )->get();
    }

    public function down_add_addr_three_gls(): string
    {
        return $this->text(
            "در صورتی که از متن ارسالی خود اطمینان دارید روی دکمه مرحله بعد بزنید"
        )->get();
    }

    public function down_add_addr_for_gls(): string
    {
        return $this->text(
            "لطفا وضعیت نمایش لینک مورد نظر را انتخاب کنید"
        )->get();
    }

    public function down_add_addr_fiv_gls(): string
    {
        return $this->text(
            "در صورتی که می خواهید لینک فیلم ساخته شده فقط در دیتابیس ذخیره شود گزینه تایید و ساخت لینک را انتخاب کنید"
        )->text(
            "در صورتی که می خواهید لینک فیلم در دیتابیس دخیره شده و در سرور هاست دانلود ، آپلود بوی ، تلگرام اپلود شود روی گزینه تایید و اپلود لینک بزنید"
        )->get();
    }

    public function down_add_addr_proc_gls($proc_status): string
    {
        $text = $this->text("افزودن لینک به ویدئو");

        $proc_status ? (
            $text->text("افزودن لینک به ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در افزودن لینک به ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function down_show_gls(): string
    {
        return $this->text(
            "در این بخش شما می توانید این لینک را مدیریت کنید"
        )->get();
    }

    public function down_edit_title_gls(): string
    {
        return $this->text(
            "در صورتی که تمایل دارید عنوان لینک را تغییر دهید یکی از عنوان زیر را انتخاب کنید"
        )->get();
    }

    public function down_edit_title_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش عنوان لینک به ویدئو");

        $proc_status ? (
            $text->text("ویرایش عنوان لینک به ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ویرایش عنوان لینک به ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function down_edit_status_gls($status): string
    {
        return $this->text(
            "در صورتی که تمایل دارید وضعیت نمایش لینک را تغییر دهید دکمه زیر را انتخاب کنید"
        )->param("عنوان فعلی", $status)->get();
    }

    public function down_edit_status_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش عنوان لینک به ویدئو");

        $proc_status ? (
            $text->text("ویرایش عنوان لینک به ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ویرایش عنوان لینک به ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function down_edit_addrs_gls(): string
    {
        return $this->text(
            "در صورتی که تمایل دارید ادرس فیلم مورد نظر را ویرایش کنید .. لینک خود را ارسال کنید"
        )->get();
    }

    public function down_edit_addrs_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش لینک به ویدئو");

        $proc_status ? (
            $text->text("ویرایش لینک به ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ویرایش لینک به ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function add_show_gls(): string
    {
        return $this->text(
            "add_show_gls"
        )->get();
    }

    public function add_mory_draft_gls(): string
    {
        return $this->text(
            "add_show_gls"
        )->get();
    }

    public function add_del_draft_gls(): string
    {
        return $this->text(
            "add_show_gls"
        )->get();
    }

    public function add_draft_save_gls(): string
    {
        return $this->text(
            "add_draft_save_gls"
        )->get();
    }

    public function add_draft_save_err_gls(): string
    {
        return $this->text(
            "خطا در انتشار این پست .. باید حتما عنوانی ست کرده باشد"
        )->get();
    }

    public function dels_gls()
    {
        return $this->text(
            "اگر از حذف این فیلم اطمینان دارید . روی دکمه حذف کن بزنید"
        )->get();
    }

    public function dels_proc_gls($status)
    {
        $text = ($status == true) ? (
            $this->text("حذف این ویدئو با موفقیت انجام شد")
        ) : $this->text("خطا در حذف این ویدئو . لطفا بعدا دوباره تلاش کنید");

        return $text->get();
    }
}