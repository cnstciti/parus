<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use backend\models\auth\Role;
//use backend\models\auth\Permission;

/**
 * Предварительно - см. https://anart.ru/yii2/2016/04/11/yii2-rbac-ponyatno-o-slozhnom.html
 *
 * Инициализатор RBAC выполняется в консоли php yii my-rbac/init
 */
class MyRbacController extends Controller {

    public function actionInit() {
        echo 'Иницализация RBAC' . PHP_EOL;
        $auth = Yii::$app->authManager;

        //На всякий случай удаляем старые данные из БД...
        $auth->removeAll();
        echo 'Удаление всех данных из БД' . PHP_EOL;

        // Создадим роль "Администратор"
        $roleAdmin = $auth->createRole(Role::ADMIN_NAME);
        $roleAdmin->description = Role::ADMIN_DESC;
        $auth->add($roleAdmin);
        echo 'Создаем роль "' . $roleAdmin->description . '"' . PHP_EOL;

        // Создадим роль "Аренда квартир и комнат"
        $roleRent = $auth->createRole(Role::RENT_NAME);
        $roleRent->description = Role::RENT_DESC;
        $auth->add($roleRent);
        echo 'Создаем роль "' . $roleRent->description . '"' . PHP_EOL;
/*
        // Создаем разрешения
        $permit = $auth->createPermission(Permission::VIEW_PARSER_INFO_PERMISSION);
        $permit->description = 'Просмотр блока информации о разборе объектов';
        $auth->add($permit);
        echo 'Создаем разрешение "' . $permit->description . '""' . PHP_EOL;
/*
        // Теперь добавим наследования. Для роли editor мы добавим разрешение updateNews,
        // а для админа добавим наследование от роли editor и еще добавим собственное разрешение viewAdminPage

        // Роли «Редактор новостей» присваиваем разрешение «Редактирование новости»
        $auth->addChild($editor,$updateNews);

        // админ наследует роль редактора новостей. Он же админ, должен уметь всё! :D
        $auth->addChild($admin, $editor);

        // Еще админ имеет собственное разрешение - «Просмотр админки»
        $auth->addChild($admin, $viewAdminPage);
*/
        // админ наследует роль арендатора. Он же админ, должен уметь всё!
        $auth->addChild($roleAdmin, $roleRent);

        // Назначаем роль admin пользователю с ID 1
        //$role = $auth->getRole(Role::ADMIN_ROLE);
        $auth->assign($roleAdmin, 1);
        echo 'Назначаем роль "' . $roleAdmin->description . '" пользователю с ID 1' . PHP_EOL;
/*
        // Назначаем разрешение viewParserInfo пользователю с ID 1
        $permit = $auth->getPermission(Permission::VIEW_PARSER_INFO_PERMISSION);
        $auth->assign($permit, 1);
        echo 'Назначаем разрешение "' . $permit->description . '" пользователю с ID 1' . PHP_EOL;
*/
/*
        // Назначаем роль арендатора пользователю с ID 2
        //$role = $auth->getRole(Role::USER_ROLE);
        $auth->assign($roleRent, 2);
        echo 'Назначаем роль "' . $roleRent->description . '" пользователю с ID 2' . PHP_EOL;
*/
    }
}
