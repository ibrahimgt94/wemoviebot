<?php

namespace lord\plg\map\opts;

class save extends edge
{
    public function rule(string $rule): self
    {
        return parent::rule("save.{$rule}.eadg");
    }

    public function __destruct()
    {
        xroute()->push_rule_data($this->datas);
    }
}