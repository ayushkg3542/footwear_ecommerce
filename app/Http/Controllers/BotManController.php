<?php

namespace App\Http\Controllers;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Incoming\Answer;

use Illuminate\Http\Request;

class BotManController extends Controller
{
    public function handle(Request $request)
    {
        $botman = app('botman');

        $botman->hears('{message}', function (BotMan $botman, $message) {
            $message = strtolower($message);

            if ($message === 'hi') {
                $this->askName($botman);
            } else {
                $botman->reply("Start a conversation by saying hi.");
            }
        });

        $botman->listen();
    }

    public function askName($botman)
    {
        $botman->ask('Hello! What is your name?', function (Answer $answer) {
            $name = $answer->getText();
            $this->say('Nice to meet you, ' . $name);

            $this->ask('Can you advise about your email address?', function (Answer $answer) {
                $email = $answer->getText();
                $this->say('Email: ' . $email);
            });
        });
    }
}