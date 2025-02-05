<?php


namespace App\Commands;


use App\Models\User;
use Carbon\Carbon;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{

    protected $name = 'start';
    protected $description = 'Запуск / Перезапуск бота';
    protected $telegramUser;
    protected $userData = null;

    public function __construct(User $telegramUser)
    {
        $this->telegramUser = $telegramUser;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        //Получаем всю информацию о пользователе
        $userData = $this->getUpdate()->message->from;
        //Получаем его уникальный ID
        $userId = $userData->id;
        //Пробуем найти юзера в БД
        $telegramUser = $this->telegramUser->where('tg_id', '=', $userId)->first();

        if ($telegramUser) {
            $this->sendAnswerForOldUsers();
        } else {
            $this->sendAnswerForNewUsers();
        }
    }

    /**
     * Добавление пользователя в базу данных.
     * @param $userData
     * @return void
     */
    public function addNewTelegramUser($userData)
    {
        $this->userData = $userData;
    }

    /**
     * Ответ старому пользователю.
     * @return void
     */
    public function sendAnswerForOldUsers()
    {
        $this->replyWithMessage([
            'text' => 'Рады видеть вас снова!🥳 Нажмите на кнопку "Лоты", чтобы просмотреть все имеющиеся торги.'
        ]);
    }

    /**
     * Ответ новому пользователю.
     * @return void
     */
    public function sendAnswerForNewUsers()
    {
        $this->replyWithMessage([
            'text' => 'Добро пожаловать телеграм бот Лотофонд! Нажмите на кнопку "Лоты", чтобы просмотреть все имеющиеся торги.'
        ]);
    }
}
