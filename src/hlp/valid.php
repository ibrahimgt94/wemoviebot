<?php

namespace lord\hlp;

use Illuminate\Support\Facades\Validator;
use lord\plg\telg\reply;
use lord\plg\telg\reply\opts\opts;
use lord\plg\telg\reply\opts\sole;
use lord\plg\telg\view;

class valid
{
    private $tmps;

    private $errs;

    private $rules;

    private array $text;

    private array $meesg;

    private $reply;

    public function __construct($text, $temps)
    {
         $this->text = $text;

         $this->meesg = [];

        $this->tmps = collect($temps)->combine([
            "cals_id", "mesg_id"
        ])->flip()->object();
    }

    public function rules(): self
    {
        $this->rules = collect(func_get_args())->join("|");

        return $this;
    }

    public function reply(string $node, string $rule, array $args = []): self
    {
        $this->reply = collect()->put("node", $node)
            ->put("rule", $rule)->put("args", $args)->object();

        return $this;
    }

    public function runing()
    {
        $valid = validator($this->text,
            ["data" => $this->rules], $this->meesg
        );

        return (! $valid->fails()) ? (
            $valid->safe()->data
        ) : $this->fails_job($valid);
    }

    private function make_opts_solo(): sole
    {
        return new sole();
    }

    private function make_opts_reply(): reply
    {
        return new reply();
    }

    private function ready_opts_solo(): reply
    {
        $opts_solo = $this->make_opts_solo();

        $opts_solo->rule($this->reply->rule)->show("بازگشت");

        empty($this->reply->args) ?: (
            collect($this->reply->args)->each(function ($val, $key) use ($opts_solo){
                $opts_solo->args($key, $val);
            })
        );

        return $this->make_opts_reply()->node(
            $this->reply->node
        )->scope($opts_solo);
    }

    private function fails_job($valid): void
    {
        $reply = $this->ready_opts_solo();

        $text1 = $valid->errors()->toArray();

        $text = "\xE2\x9A\xA0 خطا در اعتبار سنجی متن ارسالی "."\n";

        collect($text1['data'])->each(function($val) use (&$text) {
          $text .= "\n{$val}";
        });

        telg()->edit_mesg->chat_id()
            ->mesg_id($this->tmps->mesg_id)
            ->text($text)->markup($reply)->exec();

        die;
    }
}