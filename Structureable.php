<?php

interface Structureable extends Ruleable
{

    public function struct(Validator $args, $valid, $result, $stop);
}
