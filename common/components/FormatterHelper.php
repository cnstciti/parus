<?php

namespace common\components;

use yii\i18n\Formatter;
use yii\bootstrap4\Html;

class FormatterHelper extends Formatter {

    public function asPhone($value)
    {
        return preg_replace("/^(\d{3})(\d{3})(\d{2})(\d{2})$/", "8 $1 $2-$3-$4", $value);
    }

    public function asPrice($value)
    {
        return number_format($value, 0, '.', ' ');
    }

    /**
     *  преобразует первый символ в верхний регистр
     * @param string $str - строка
     * @param string $encoding - кодировка, по-умолчанию UTF-8
     *
     * @return string
     */
    public function mb_ucfirst($str, $encoding = 'UTF-8')
    {
        /**
         * проверяем, что функция mb_ucfirst не объявлена
         * и включено расширение mbstring (Multibyte String Functions)
         */
        if (!function_exists('mb_ucfirst') && extension_loaded('mbstring')) {
            $str = mb_ereg_replace('^[\ ]+', '', $str);
            $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
                mb_substr($str, 1, mb_strlen($str), $encoding);
            return $str;
        }
        /*
                $str = 'первые буквы';

                // пробуем кириллицу в юникоде преобразовать функцией ucfirst
                echo ucfirst($str) . '<br>';

                // пробуем кириллицу в юникоде преобразовать функцией ucwords
                echo ucwords($str) . '<br>';

                // обрабатываем объявленной функцией mb_ucfirst()
                echo mb_ucfirst($str) . '<br>';

                // преобразовываем функцией mb_convert_case
                echo mb_convert_case($str, MB_CASE_TITLE, 'UTF-8');
                */
    }

    public function optionsCheckboxList()
    {
        return [
            'item' => function($index, $label, $name, $checked, $value) {
                $checked = $checked ? 'checked' : '';
                return "<label class='checkbox col-12 p-0' style='font-weight: normal;'><input type='checkbox' {$checked} name='{$name}' value='{$value}'> {$label}</label>";
/*
                return Html::checkbox($name, $checked, [
                    'value' => $value,
                    //'label' => $label,
                    'label' => '<div class="row"><div class="col-12">' . $label . '</div></div>',
                ]);
*/
            },
            //'id' => 'myMinor',
        ];
    }

}
