<?php
namespace backend\models\block;

use backend\widgets\common\BlockDataWidget;
use Exception;

abstract class BaseBlock
{
    const CLASS_SUCCESS = 'border-success';
    const CLASS_HEADER_SUCCESS = 'border-success bg-success text-white';
    const CLASS_CARD_WARNING = 'border-warning';
    const CLASS_HEADER_WARNING = 'border-warning bg-warning text-white';
    const DEFAULT_CLASS_ICON = 'icon';
    const DEFAULT_ICON = 'fa-pen';

    /**
     *
     *  [
     *      'class'     => <string>,        // CSS-класс рамки блока, по умолчанию: self::CLASS_CARD_WARNING
     *       'header'    => [
     *           'class' => <string>,       // CSS-класс заголовка блока, по умолчанию: self::CLASS_HEADER_WARNING
     *           'title'  => <string>,      // текст заголовка блока
     *           'button' => [
     *               'id'     => <string>,  // ИД кнопки
     *               'class'  => <string>,  // CSS-класс кнопки, по умолчанию: self::DEFAULT_CLASS_ICON
     *               'icon'   => <string>,  // CSS-класс иконки кнопки, по умолчанию: self::DEFAULT_ICON
     *               'title'  => <string>,  // текст подписи к кнопке, по умолчанию: 'Редактировать'
     *               'action' => <string>,  // действие по кнопке
     *           ],
     *       ],
     *       'content'   => <string>,       // содеримое блока
     *  ]
     */
    public static function showBlock(array $params)
    {
        try {
            self::_checkHeaderTitle($params['header']['title']);
            self::_checkHeaderButtonId($params['header']['button']['id']);
            self::_checkHeaderButtonAction($params['header']['button']['action']);
            self::_checkContent($params['content']);

            $params['class'] = isset($params['class']) ? $params['class'] : self::CLASS_CARD_WARNING;
            $params['header']['class'] = isset($params['header']['class']) ? $params['header']['class'] : self::CLASS_HEADER_WARNING;
            $params['header']['button']['class'] = isset($params['header']['button']['class']) ? $params['header']['button']['class'] : self::DEFAULT_CLASS_ICON;
            $params['header']['button']['icon'] = isset($params['header']['button']['icon']) ? $params['header']['button']['icon'] : self::DEFAULT_ICON;
            $params['header']['button']['title'] = isset($params['header']['button']['title']) ? $params['header']['button']['title'] : 'Редактировать';
            return BlockDataWidget::widget(['params' => $params]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function _checkHeaderTitle($value) : void
    {
        if (!isset($value) || empty($value)) {
            throw new Exception('Ошибка в коде. Отсутствует обязательный параметр "params[header][title]"');
        }
    }

    public static function _checkHeaderButtonId($value) : void
    {
        if (!isset($value) || empty($value)) {
            throw new Exception('Ошибка в коде. Отсутствует обязательный параметр "params[header][button][id]"');
        }
    }

    public static function _checkHeaderButtonAction($value) : void
    {
        if (!isset($value) || empty($value)) {
            throw new Exception('Ошибка в коде. Отсутствует обязательный параметр "params[header][button][action]"');
        }
    }

    public static function _checkContent($value) : void
    {
        if (!isset($value) || empty($value)) {
            throw new Exception('Ошибка в коде. Отсутствует обязательный параметр "params[content]"');
        }
    }

}
