<?php

namespace App\Http\Services\Parse;

class PriceFormatterService
{
    protected $priceRegex = "/(?(DEFINE)(?'usa_thousands_separators'[ ,]))(?(DEFINE)(?'usa_decimal_separators'[.]))(?(DEFINE)(?'cis_thousands_separators'[ .]))(?(DEFINE)(?'cis_decimal_separators'[,]))\b(?<![., ])(?:(?'usa'(?:(?:(?:(?:(?:[1-9]\d{0,2}))(?:(?:(?:(?&usa_thousands_separators)?[\d]{3}(?&usa_thousands_separators)?)+(?:[\d]{3}))|(?:(?&usa_thousands_separators)?[\d]{3}))?)|[0])(?:(?&usa_decimal_separators)\d{2})?))|(?'cis'(?:(?:(?:(?:(?:[1-9]\d{0,2}))(?:(?:(?:(?&cis_thousands_separators)?[\d]{3}(?&cis_thousands_separators)?)+(?:[\d]{3}))|(?:(?&cis_thousands_separators)?[\d]{3}))?)|[0])(?:(?&cis_decimal_separators)\d{2})?)))\b(?![., ])/";

    public function formatPrice($price){
        preg_match_all($this->priceRegex, $price, $match);
        if (count($match[0])>0){
            if(strlen($match['usa'][0])>0){
                $price = str_replace(',', '', $match['usa'][0]);
            } elseif(strlen($match['cis'][0])>0){
                $price = str_replace('.', '', $match['cis'][0]);
            }else{
                $price = $match[0][0];
            }
        }
        return strlen($price) > 0 ? (float)number_format((float)preg_replace("/[^,.0-9]/", '',
            str_replace(',', '.', $price)), 2, '.', '') : 0;
    }

}
