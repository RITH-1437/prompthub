<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AiPromptController extends Controller
{
    public function index()
    {
        return view('ai-generator.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);

        $client = new Client([
            'timeout' => 120,
        ]);

        $models = ['google/gemini-2.5-flash-lite', 'openrouter/free'];

        foreach ($models as $model) {
            try {
                $response = $client->post(
                    'https://openrouter.ai/api/v1/chat/completions',
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                            'Content-Type'  => 'application/json',
                            'HTTP-Referer'  => config('app.url'),
                            'X-Title'       => 'PromptHub',
                        ],

                        'json' => [
                            'model' => $model,

                            'messages' => [
                                [
                                    'role' => 'system',
                                    'content' => 'You are an expert AI prompt engineer.'
                                ],
                                [
                                    'role' => 'user',
                                    'content' => $request->description
                                ]
                            ]
                        ]
                    ]
                );

                $data = json_decode(
                    $response->getBody()->getContents(),
                    true
                );

                $generated =
                    $data['choices'][0]['message']['content']
                    ?? 'No response generated.';
                break;
            } catch (\Exception $e) {
                $generated = 'No response generated.';
            }
        }

        return back()->with(
            'generated',
            $generated
        );
    }

    public function assist(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $client = new Client([
            'timeout' => 120,
        ]);

        $messages = [
            [
                'role' => 'system',
                'content' => 'You are an expert AI prompt engineer assistant. Help users craft high-quality prompts. Keep responses concise and focused on prompt creation.'
            ],
            [
                'role' => 'user',
                'content' => $request->message
            ]
        ];

        if ($request->has('history')) {
            $history = $request->history;
            $messages = [
                [
                    'role' => 'system',
                    'content' => 'You are an expert AI prompt engineer assistant. Help users craft high-quality prompts. Keep responses concise and focused on prompt creation.'
                ]
            ];

            foreach ($history as $msg) {
                $messages[] = [
                    'role' => $msg['role'],
                    'content' => $msg['content']
                ];
            }

            $messages[] = [
                'role' => 'user',
                'content' => $request->message
            ];
        }

        $models = ['google/gemini-2.5-flash-lite', 'openrouter/free'];

        foreach ($models as $model) {
            try {
                $response = $client->post(
                    'https://openrouter.ai/api/v1/chat/completions',
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                            'Content-Type'  => 'application/json',
                            'HTTP-Referer'  => config('app.url'),
                            'X-Title'       => 'PromptHub',
                        ],
                        'json' => [
                            'model' => $model,
                            'messages' => $messages,
                        ]
                    ]
                );

                $data = json_decode(
                    $response->getBody()->getContents(),
                    true
                );

                $reply = $data['choices'][0]['message']['content'] ?? 'No response generated.';
                break;
            } catch (\Exception $e) {
                $reply = 'No response generated.';
            }
        }

        return response()->json([
            'response' => $reply,
        ]);
    }
}