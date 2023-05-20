<?php

namespace lord\plg\map\opts;

class cmd extends edge
{
    public function rule(string $rule): self
    {
        return parent::rule("/{$rule}");
    }

    public function __destruct()
    {
        xroute()->push_rule_data($this->datas);
    }
}