<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\ContactsRequest;
use App\Http\Requests\QuestionRequest;
use App\Jobs\SendApplication;
use App\Models\Application;
use App\Models\Contact;
use App\Models\Lot;
use App\Models\User;
use App\Notifications\ApplicationTelegramNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ApplicationController extends Controller
{
    public function sendApplication(ApplicationRequest $request)
    {
        $user = User::find(auth()->id());
        $socials = 'Не указаны';
        if (gettype($request->socialsForAnswer) == 'array') {
            $socials = '';
            $count = count($request->socialsForAnswer);
            foreach ($request->socialsForAnswer as $key => $social) {
                if (++$key !== $count) {
                    $socials .= $social . ' ,';
                } else {
                    $socials .= $social;
                }
            }
        }
        $username = $request->name ?? $user->surname . ' ' . $user->name;
        $lot = URL::to('/lot/' . $request->lotId);
        $lotDesc = Lot::find($request->lotId)['description'];
        $html = $request->lotId ? "
            Пользователь $username оставил заявку на покупку без ЭЦП.
            <strong> Описание лота:</strong>
            <p>$lotDesc</p>
            <a href='$lot'> Ссылка на лот </a>" : "Пользователь $username оставил заявку на покупку через агента.";
        $html .= "<br>
            <strong>Почта: $request->email</strong>
             <br>
            <strong>Телефон: $request->phone</strong>
            <p>Социальные сети для ответа: $socials</p>";
        if (isset($request->dateForCallback) && strlen($request->dateForCallback) > 0) {
            $dateForCallback = Carbon::parse($request->dateForCallback)->format('d.m.Y H:i');
            $html .= "
            <p>Дата и время для ответа: $dateForCallback</p>";
        }
        $subject = $request->lotId ? 'Новая заявка на покупку без ЭЦП' : 'Новая заявка на покупку через агента';
        if($request->lotId){
            $emails = Contact::where('type', 'Отправка заявок на покупку без ЭЦП')->pluck('contact')->toArray();
        }else{
            $emails = Contact::where('type', 'Отправка заявок на покупки через агента')->pluck('contact')->toArray();
        }
        Application::create([
            'user_id' => auth()->id(),
            'lot_id' => $request->lotId,
            'email' => $request->email,
            'phone' => $request->phone,
            'for_answer' => $socials,
            'answer_date' => $request->dateForCallback,
            'username' => $username,
            'type'=>$request->lotId ? 'Покупка без ЭЦП' : 'Покупка через агента'
        ]);
        if(count($emails)>0) {
            dispatch_sync(new SendApplication($html, $subject, $emails));
        }
        $token =  config('telegram.bot_token');
        Notification::route('telegram', $token)
            ->notify(new ApplicationTelegramNotification($html));
        return response(null, 200);
    }

    public function sendQuestion(QuestionRequest $request)
    {
        $user = User::find(auth()->id());
        $username = $user->surname . ' ' . $user->name;
        $html = "Пользователь $username  задал вопрос по теме:
            <p>$request->topic</p>
            <p>$request->question</p>
            <strong>Почта: $request->email</strong>";
        $files = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = str_replace(" ", "-", $file->getClientOriginalName());
                $path = Storage::disk('public')->put('questions/user-' . auth()->id() . '/' . $filename, File::get($file));
                $path = Storage::url('questions/user-' . auth()->id() . '/' . $filename);
                $html .= " <br><a href=$path> Прикрепленный файл </a>";
                $files[] = 'questions/user-' . auth()->id() . '/' . $filename;
            }
        }
        $subject = 'Новый вопрос';
        Application::create([
            'user_id' => auth()->id(),
            'email' => $request->email,
            'topic'=>$request->topic,
            'question'=>$request->question,
            'username' => $username,
            'files'=>$files,
            'type'=>$subject
        ]);
        $emails = Contact::where('type', 'Отправка форм с вопросами')->pluck('contact')->toArray();
        if(count($emails)>0) {
            dispatch_sync(new SendApplication($html, $subject, $emails));
        }
        return response(null, 200);
    }

    public function sendContacts(ContactsRequest $request)
    {
        $communication = 'Почта для ответа: ' . $request->communication;
        if ($request->communicationType == 'phone') {
            $communication = 'Телефон для ответа: ' . $request->communication;
        }

        $html = "У Вас новый вопрос:
            <p>$request->question</p>
            <strong>$communication</strong>";
        $subject = 'Новый вопрос';
        Application::create([
            'email' => $request->communicationType == 'email' ?  $request->communication : null,
            'phone' => $request->communicationType == 'phone' ?  $request->communication : null,
            'question'=>$request->question,
            'type'=>$subject
        ]);
        $emails = Contact::where('type', 'Отправка контактных форм')->pluck('contact')->toArray();
        if(count($emails)>0) {
            dispatch_sync(new SendApplication($html, $subject, $emails));
        }
        return response(null, 200);
    }

}
