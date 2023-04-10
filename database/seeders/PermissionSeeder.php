<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           /* ['name' => 'role-list', 'visible_name' => 'Просмотр ролей', 'permission_group' => 'Роли'],
            ['name' => 'role-edit', 'visible_name' => 'Редактирование ролей', 'permission_group' => 'Роли'],
            ['name' => 'role-add', 'visible_name' => 'Добавление ролей', 'permission_group' => 'Роли'],
            ['name' => 'role-delete', 'visible_name' => 'Удаление ролей', 'permission_group' => 'Роли'],

            ['name' => 'user-list', 'visible_name' => 'Просмотр пользователей', 'permission_group' => 'Пользователи'],
            ['name' => 'user-edit', 'visible_name' => 'Редактирование пользователя', 'permission_group' => 'Пользователи'],
            ['name' => 'user-add', 'visible_name' => 'Добавление пользователя', 'permission_group' => 'Пользователи'],
            ['name' => 'user-delete', 'visible_name' => 'Удаление пользователя', 'permission_group' => 'Пользователи'],

            ['name' => 'text-data-list', 'visible_name' => 'Просмотр текстовых данных', 'permission_group' => 'Текстовые данные'],
            ['name' => 'text-data-edit', 'visible_name' => 'Редактирование текстовых данных', 'permission_group' => 'Текстовые данные'],
            ['name' => 'text-data-add', 'visible_name' => 'Добавление текстовых данных', 'permission_group' => 'Текстовые данные'],
            ['name' => 'text-data-delete', 'visible_name' => 'Удаление текстовых данных', 'permission_group' => 'Текстовые данные'],

            ['name' => 'emails-list', 'visible_name' => 'Просмотр контактных почт', 'permission_group' => 'Контактные почты'],
            ['name' => 'emails-add', 'visible_name' => 'Добавление контактных почт', 'permission_group' => 'Контактные почты'],
            ['name' => 'emails-delete', 'visible_name' => 'Удаление контактных почт', 'permission_group' => 'Контактные почты'],

            ['name' => 'application-list', 'visible_name' => 'Просмотр заявок', 'permission_group' => 'Заявки'],
            ['name' => 'application-edit', 'visible_name' => 'Редактирование заявок', 'permission_group' => 'Заявки'],

            ['name' => 'lot-list', 'visible_name' => 'Просмотр лотов', 'permission_group' => 'Лоты'],
            ['name' => 'lot-edit', 'visible_name' => 'Редактирование лотов', 'permission_group' => 'Лоты'],
            ['name' => 'lot-delete', 'visible_name' => 'Удаление лотов', 'permission_group' => 'Лоты'],

            ['name' => 'tariff-list', 'visible_name' => 'Просмотр тарифов', 'permission_group' => 'Тарифы'],
            ['name' => 'tariff-edit', 'visible_name' => 'Редактирование тарифов', 'permission_group' => 'Тарифы'],
            ['name' => 'tariff-add', 'visible_name' => 'Добавление тарифов', 'permission_group' => 'Тарифы'],
            ['name' => 'tariff-delete', 'visible_name' => 'Удаление тарифов', 'permission_group' => 'Тарифы'],

            ['name' => 'holidays-list', 'visible_name' => 'Просмотр праздничных дней', 'permission_group' => 'Праздничные дни'],
            ['name' => 'holidays-add', 'visible_name' => 'Добавление праздничных дней', 'permission_group' => 'Праздничные дни'],
            ['name' => 'holidays-delete', 'visible_name' => 'Удаление праздничных дней', 'permission_group' => 'Праздничные дни'],

            ['name' => 'content-rules-list', 'visible_name' => 'Просмотр ограничений контента', 'permission_group' => 'Ограничения контента'],
            ['name' => 'content-rules-edit', 'visible_name' => 'Изменение ограничений контента', 'permission_group' => 'Ограничения контента'],

            ['name' => 'egrn-statements-list', 'visible_name' => 'Просмотр отчетов ЕГРН', 'permission_group' => 'Отчеты ЕГРН'],

            ['name' => 'additions-list', 'visible_name' => 'Просмотр ответов на запросы доп. информации по лотам', 'permission_group' => 'Запросы доп. информации'],
            ['name' => 'additions-edit', 'visible_name' => 'Редактирование ответов на запросы доп. информации по лотам', 'permission_group' => 'Запросы доп. информации'],
            ['name' => 'additions-add', 'visible_name' => 'Добавление ответов на запросы доп. информации по лотам', 'permission_group' => 'Запросы доп. информации'],
            ['name' => 'additions-delete', 'visible_name' => 'Удаление ответов на запросы доп. информации по лотам', 'permission_group' => 'Запросы доп. информации'],

            ['name' => 'news-list', 'visible_name' => 'Просмотр информационных сообщений', 'permission_group' => 'Информационные сообщения'],
            ['name' => 'news-edit', 'visible_name' => 'Редактирование информационных сообщений', 'permission_group' => 'Информационные сообщения'],
            ['name' => 'news-add', 'visible_name' => 'Добавление информационных сообщений', 'permission_group' => 'Информационные сообщения'],
            ['name' => 'news-delete', 'visible_name' => 'Удаление информационных сообщений', 'permission_group' => 'Информационные сообщения'],*/
            ['name' => 'change-watermark', 'visible_name' => 'Изменение водяного знака', 'permission_group' => 'Настройки'],
            ['name' => 'change-trial-period', 'visible_name' => 'Изменение длительности тестового периода', 'permission_group' => 'Настройки'],

        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'visible_name' => $permission['visible_name'],
                'permission_group' => $permission['permission_group'],
                'guard_name'=>'api'
            ]);
        }

        $role = Role::where('name', 'admin')->first();
        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);
    }
}
