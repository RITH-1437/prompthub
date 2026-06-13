<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function listConversations()
    {
        $conversations = Conversation::where('user_id', auth()->id())
            ->latest()
            ->get(['id', 'title', 'created_at']);

        return response()->json($conversations);
    }

    public function getMessages($id)
    {
        $conversation = Conversation::where('user_id', auth()->id())
            ->findOrFail($id);

        $messages = $conversation->messages()
            ->orderBy('id')
            ->get(['role', 'content']);

        return response()->json([
            'messages' => $messages,
            'title' => $conversation->title,
        ]);
    }

    public function destroyConversation($id)
    {
        $conversation = Conversation::where('user_id', auth()->id())
            ->findOrFail($id);

        $conversation->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function sendAjax(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $conversationId = $request->conversation;
        $conversation = $conversationId
            ? Conversation::where('user_id', auth()->id())->findOrFail($conversationId)
            : Conversation::create([
                'user_id' => auth()->id(),
                'title' => 'New Chat',
            ]);

        $conversation->messages()->create([
            'role' => 'user',
            'content' => $request->message
        ]);

        if (!$conversation->title || $conversation->title === 'New Chat') {
            $conversation->update([
                'title' => str($request->message)->limit(40)
            ]);
        }

        $client = new \GuzzleHttp\Client(['timeout' => 120]);

        $models = ['google/gemini-2.5-flash-lite', 'openrouter/free'];

        foreach ($models as $model) {
            try {
                $response = $client->post(
                    'https://openrouter.ai/api/v1/chat/completions',
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                            'Content-Type' => 'application/json',
                            'HTTP-Referer' => config('app.url'),
                            'X-Title' => 'PromptHub',
                        ],
                        'json' => [
                            'model' => $model,

                            'messages' => array_merge(
                                [
                                    [
                                        'role' => 'system',
                                        'content' => 'You are a helpful AI assistant.'
                                    ]
                                ],

                                $conversation->messages()
                                    ->orderBy('id')
                                    ->get()
                                    ->map(function ($message) {
                                        return [
                                            'role' => $message->role,
                                            'content' => $message->content
                                        ];
                                    })
                                    ->toArray()
                            )
                        ]
                    ]
                );

                $data = json_decode($response->getBody()->getContents(), true);
                $reply = $data['choices'][0]['message']['content'] ?? 'No response';
                break;
            } catch (\Exception $e) {
                $reply = 'No response';
            }
        }

        $conversation->messages()->create([
            'role' => 'assistant',
            'content' => $reply
        ]);

        return response()->json([
            'response' => $reply,
            'conversation' => $conversation->id,
        ]);
    }
}
