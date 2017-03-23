<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Laravel\Facades\Telegram;

use App\RegAdser;

class TelegramController extends Controller
{
    public function __construct()
    {
        $this->group_chat_id     = '-201163973';
    }

    public function getHome()
    {
        return view('telegram.home');
    }

    public function getUpdates()
    {
        $updates = Telegram::getUpdates();
        dd($updates);
    }

    public function getSendMessage()
    {
        return view('telegram.send');
    }

    public function postSendMessage(Request $request)
    {
        $rules = [
            'message' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            return redirect()->back()
                ->with('status', 'danger')
                ->with('message', 'Message is required');
        }

        $adser_name      = 'Nama Perusahaan: Fave Hotel Group';
        $adser_contact   = 'Kontak: favehotel_solo@gmail.com';
        $adser_package   = 'Paket: Full Wrap';
        $adser_text      = $request->get('message');
        $message         = '#NEWadser '.PHP_EOL.
                                $adser_name.PHP_EOL.
                                $adser_contact.PHP_EOL.
                                $adser_package.PHP_EOL.
                                $adser_text . PHP_EOL . '<b>bold</b>, <strong>bold</strong>
                            <i>italic</i>, <em>italic</em>
                            <a href="http://www.example.com/">inline URL</a>
                            <code>inline fixed-width code</code>
                            <pre>pre-formatted fixed-width code block</pre>';
        Telegram::sendMessage([
            'chat_id' => $this->group_chat_id,
            'text' => $message,
            'parse_mode' => 'html', // optional html,markdown
        ]);

        return redirect()->back()
            ->with('status', 'success')
            ->with('message', 'Message sent');
    }    

    public function postSendAjax(Request $request)
    {
        $origin = $request['originAllowed'];
        header('Access-Control-Allow-Origin: '.$origin);
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Max-Age: 1000');
        $adser_name      = $request['adserName'];
        // return $adser_name;
        $adser_contact   = $request['adserContact'];
        $adser_package   = $request['adserPackage'];
        $message         = '#NEWadser' .PHP_EOL.
                            'Perusahaan: <b>'.$adser_name.'</b>' .PHP_EOL.
                            'Paket disukai: <b>'.$adser_package.'</b>' .PHP_EOL.
                            'Kontak: '.$adser_contact;

        // // Cek Duplicate
        // $cek    = RegAdser::where([
        //                         ['name' => $adser_name],
        //                         ['contact' => $adser_contact],
        //                         ['package' => $adser_package],
        //                         ])->first();
        // if(! isset($cek->id)) {
            $adser  = new RegAdser();
            $adser->name       = $adser_name;
            $adser->contact    = $adser_contact;
            $adser->package    = addslashes($adser_package);
            $adser->save();
        // }

        $send = Telegram::sendMessage([
            'chat_id' => $this->group_chat_id,
            'text' => $message,
            'parse_mode' => 'html', // optional html,markdown
        ]);
        // return \Response::json($request['adserName']);
        return \Response::json($send);
    }
}