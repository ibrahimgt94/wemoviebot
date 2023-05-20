<?php

namespace lord\aps\panel\movie\orgs;

trait add_view
{
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

    public function add_draft_title_gls($title): string
    {
        return $this->text(
            "عنوان فیلم مورد نظر را به فارسی ارسال کنید"
        )->param("عنوان فعلی", $title)->get();
    }

    public function add_draft_title_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش عنوان ویدئو");

        $proc_status ? (
            $text->text("عنوان ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ابدیت عنوان ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function add_draft_image_gls(): string
    {
        return $this->text(
            "برای ویرایش تصویر فیلم مورد نظر لطفا یه تصویر ارسال کنید"
        )->get();
    }

    public function add_draft_image_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش تصویر ویدئو");

        $proc_status ? (
            $text->text("تصویر ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ابدیت تصویر ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function add_draft_summary_gls($summary): string
    {
        return $this->text(
            "برای ویرایش خلاصه فیلم مورد نظر لطفا متن خلاصه فیلم را ارسال کنید"
        )->param("خلاصه فعلی", $summary)->get();
    }

    public function add_draft_summary_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش خلاصه ویدئو");

        $proc_status ? (
            $text->text("خلاصه ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ابدیت خلاصه ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function add_draft_status_gls($status): string
    {
        return $this->text(
            "یکی از وضعیت ها زیر را برای نمایش یا عدم نمایش پست در صفحه اصلی انتخاب کنید"
        )->param("وضعیت فعلی", $status)->get();
    }

    public function add_draft_status_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش وضعیت ویدئو");

        $proc_status ? (
        $text->text("وضعیت ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ابدیت وضعیت ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function add_draft_property_gls(): string
    {
        return $this->text(
            "در این بخش شما می توانید خصوصیات و اطلاعات فیلم خود را انتخاب کنید"
        )->get();
    }

    public function add_draft_director_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند کارگردان برای این فیلم انتخاب کنید"
        )->get();
    }

    public function add_draft_producer_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند تهیه کننده برای این فیلم انتخاب کنید"
        )->get();
    }

    public function add_draft_writer_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند نویسنده برای این فیلم انتخاب کنید"
        )->get();
    }

    public function add_draft_actors_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند بازیگر برای این فیلم انتخاب کنید"
        )->get();
    }

    public function add_draft_asong_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند اهنگساز برای این فیلم انتخاب کنید"
        )->get();
    }

    public function add_draft_singer_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید یک یا چند خواننده برای این فیلم انتخاب کنید"
        )->get();
    }

    public function add_draft_filming_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید مدیر فیلم برداری برای این فیلم انتخاب کنید"
        )->get();
    }

    public function add_draft_year_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید سال تولید این فیلم انتخاب کنید"
        )->get();
    }

    public function add_draft_duration_gls(): string
    {
        return $this->text(
            "در این بخش شما میتوانید مدت زمان این فیلم انتخاب کنید"
        )->get();
    }

    public function add_draft_down_gls(): string
    {
        return $this->text(
            "در این بخش شما می توانید لینک های فیلم مورد نظر را مدیریت کنید"
        )->get();
    }

    public function add_draft_down_add_addr_gls(): string
    {
        return $this->text(
            "لطفا نوع لینک مورد نظر را انتخاب کنید"
        )->get();
    }

    public function add_draft_down_add_addr_two_gls(): string
    {
        return $this->text(
            "لطفا لینک فیلم مورد نظر را ارسال کنید"
        )->get();
    }

    public function add_draft_down_add_addr_three_gls(): string
    {
        return $this->text(
            "در صورتی که از متن ارسالی خود اطمینان دارید روی دکمه مرحله بعد بزنید"
        )->get();
    }

    public function add_draft_down_add_addr_for_gls(): string
    {
        return $this->text(
            "لطفا وضعیت نمایش لینک مورد نظر را انتخاب کنید"
        )->get();
    }

    public function add_draft_down_add_addr_fiv_gls(): string
    {
        return $this->text(
            "در صورتی که می خواهید لینک فیلم ساخته شده فقط در دیتابیس ذخیره شود گزینه تایید و ساخت لینک را انتخاب کنید"
        )->text(
            "در صورتی که می خواهید لینک فیلم در دیتابیس دخیره شده و در سرور هاست دانلود ، آپلود بوی ، تلگرام اپلود شود روی گزینه تایید و اپلود لینک بزنید"
        )->get();
    }

    public function add_draft_down_add_addr_proc_gls($proc_status): string
    {
        $text = $this->text("افزودن لینک به ویدئو");

        $proc_status ? (
        $text->text("افزودن لینک به ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در افزودن لینک به ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function add_draft_down_show_gls(): string
    {
        return $this->text(
            "در این بخش شما می توانید این لینک را مدیریت کنید"
        )->get();
    }

    public function add_draft_down_edit_title_gls(): string
    {
        return $this->text(
            "در صورتی که تمایل دارید عنوان لینک را تغییر دهید یکی از عنوان زیر را انتخاب کنید"
        )->get();
    }

    public function add_draft_down_edit_title_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش عنوان لینک به ویدئو");

        $proc_status ? (
        $text->text("ویرایش عنوان لینک به ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ویرایش عنوان لینک به ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function add_draft_down_edit_status_gls($status): string
    {
        return $this->text(
            "در صورتی که تمایل دارید وضعیت نمایش لینک را تغییر دهید دکمه زیر را انتخاب کنید"
        )->param("عنوان فعلی", $status)->get();
    }

    public function add_draft_down_edit_status_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش عنوان لینک به ویدئو");

        $proc_status ? (
        $text->text("ویرایش عنوان لینک به ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ویرایش عنوان لینک به ویدئو . دوباره تلاش کنید");

        return $text->get();
    }

    public function add_draft_down_edit_addrs_gls(): string
    {
        return $this->text(
            "در صورتی که تمایل دارید ادرس فیلم مورد نظر را ویرایش کنید .. لینک خود را ارسال کنید"
        )->get();
    }

    public function add_draft_down_edit_addrs_proc_gls($proc_status): string
    {
        $text = $this->text("ویرایش لینک به ویدئو");

        $proc_status ? (
        $text->text("ویرایش لینک به ویدئو با موفقیت ابدیت شد")
        ) : $text->text("خطا در ویرایش لینک به ویدئو . دوباره تلاش کنید");

        return $text->get();
    }
}