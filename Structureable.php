<?php

interface Structureable extends Ruleable
{
    public function struct($valid, $value, $stop);
}
