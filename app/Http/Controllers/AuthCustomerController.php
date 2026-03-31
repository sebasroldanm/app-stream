<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Traits\SyncData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthCustomerController extends Controller
{
    use SyncData;

    public function index()
    {
        return view('auth.login');
    }

    public function signup()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        // Validar campos
        $request->validate([
            'username' => 'required|string|max:255|unique:customers,username',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:8',
        ]);

        $customer = Customer::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if ($customer && Hash::check($request->password, $customer->password)) {
            Auth::guard('customer')->login($customer);
            $customer->update([
                'last_login_at' => now(),
                'last_login_ip' => request()->ip(),
            ]);

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => __('The credentials do not match our records.'),
        ])->withInput();
    }

    public function logout()
    {
        Auth::guard('customer')->logout();  // Cierra la sesión del usuario
        return redirect()->route('login');
    }

    public function test(Request $request)
    {
        $chat_id = $request->chat;
        $from_chat_id = $request->from;
        $init = $request->init;
        $end = $request->end;

        $chat = \App\Models\TelegramChat::where('username', $from_chat_id)->first();

        if (!$chat) {
            dd('Chat no encontrado');
        }

        for ($i = $init; $i <= $end; $i++) {
            try {
                $message = \Telegram\Bot\Laravel\Facades\Telegram::forwardMessage([
                    'chat_id' => $chat_id,
                    'from_chat_id' => '@' . $from_chat_id,
                    'message_id' => $i
                ]);
                if ($message->has('photo') || $message->has('video')) {
                    $content = $message->getCaption();
                    $entities = $message->getCaptionEntities();
                } else {
                    $content = $message->getText() ?: $message->getCaption();
                    $entities = $message->getEntities() ?: $message->getCaptionEntities() ?: [];

                    $telegramMessage = \App\Models\TelegramMessage::updateOrCreate([
                        'fk_telegram_chats_id' => $chat->id,
                        'message_id' => $message->getMessageId(),
                    ], [
                        'text' => $message->getText(),
                    ]);

                    $parsed = $this->parseEntities($content, $entities);

                    \Illuminate\Support\Facades\DB::transaction(function () use ($telegramMessage, $parsed) {

                        $positions = [];

                        foreach ($parsed as $index => $item) {

                            $positions[] = $index;

                            \App\Models\TelegramCaption::updateOrCreate(
                                [
                                    'fk_telegram_messages_id' => $telegramMessage->id,
                                    'position' => $index, // 🔥 clave real
                                ],
                                [
                                    'caption' => $item['content'],
                                    'type' => $item['type'],
                                    'offset' => $item['offset'] ?? null,
                                    'length' => $item['length'] ?? null,
                                ]
                            );
                        }

                        // 🔥 eliminar los que ya no existen
                        \App\Models\TelegramCaption::where('fk_telegram_messages_id', $telegramMessage->id)
                            ->whereNotIn('position', $positions)
                            ->delete();
                    });

                    dd($parsed, $content, $message);
                }
            } catch (\Exception $e) {
                // dd($e->getMessage());
            }
        }
    }
    function parseEntities($text, $entities)
    {
        $result = [];
        $pointer = 0;

        foreach ($entities as $entity) {
            $offset = $entity['offset'];
            $length = $entity['length'];
            $type = $entity['type'];

            if ($offset > $pointer) {
                $result[] = [
                    'type' => 'text',
                    'content' => mb_substr($text, $pointer, $offset - $pointer),
                ];
            }

            $result[] = [
                'type' => $type,
                'content' => mb_substr($text, $offset, $length),
            ];

            $pointer = $offset + $length;
        }

        if ($pointer < mb_strlen($text)) {
            $result[] = [
                'type' => 'text',
                'content' => mb_substr($text, $pointer),
            ];
        }

        return $result;
    }

    public function search(Request $request)
    {
        $echo = $request->all();

        $request->validate([
            'q' => 'required',
        ]);

        $keyword = $request->q;

        $response = $this->searchGlobal($keyword);

        return response()->json($response);
    }
}
