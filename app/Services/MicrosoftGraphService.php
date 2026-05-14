<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MicrosoftGraphService
{
    protected $accessToken;
    protected $client;

    public function __construct()
    {
        Log::info('MicrosoftGraphService: Iniciando constructor');
        $this->client = new Client([
            'base_uri' => 'https://graph.microsoft.com/v1.0/',
            'timeout'  => 15,
        ]);
        $this->getAccessToken(); 
        Log::info('MicrosoftGraphService: Constructor completado');
    }

    private function getAccessToken()
    {
        Log::info('MicrosoftGraphService: Iniciando obtención de token');

        try {
            $response = (new Client())->post('https://login.microsoftonline.com/' . env('MICROSOFT_GRAPH_TENANT_ID') . '/oauth2/v2.0/token', [
                'form_params' => [
                    'client_id' => env('MICROSOFT_GRAPH_CLIENT_ID'),
                    'client_secret' => env('MICROSOFT_GRAPH_CLIENT_SECRET'),
                    'scope' => 'https://graph.microsoft.com/.default',
                    'grant_type' => 'client_credentials',
                ],
            ]);

            $token = json_decode($response->getBody()->getContents());

            if (isset($token->access_token)) {
                Log::info('MicrosoftGraphService: Token de acceso obtenido correctamente');
                $this->accessToken = $token->access_token;
            } else {
                Log::error('MicrosoftGraphService: Error - No se pudo obtener el token de acceso');
                throw new \Exception('No se recibió un token de acceso válido en la respuesta');
            }
        } catch (\Exception $e) {
            Log::error('MicrosoftGraphService: Excepción general: ' . $e->getMessage());
            throw new \Exception('Error al obtener token de acceso: ' . $e->getMessage());
        }
    }

    public function sendMail($subject, $body, $to, $attachments = [])
    {
        Log::info('MicrosoftGraphService: Iniciando envío de correo');

        try {
            $message = [
                'message' => [
                    'subject' => $subject,
                    'body' => [
                        'contentType' => 'HTML',
                        'content' => $body
                    ],
                    'toRecipients' => array_map(function($recipient) {
                        return [
                            'emailAddress' => [
                                'address' => $recipient
                            ]
                        ];
                    }, is_array($to) ? $to : [$to])
                ],
                'saveToSentItems' => true
            ];

            // Agregar adjuntos si existen
            if (!empty($attachments)) {
                $message['message']['attachments'] = [];
                foreach ($attachments as $attachment) {
                    $message['message']['attachments'][] = [
                        '@odata.type' => '#microsoft.graph.fileAttachment',
                        'name' => $attachment['name'],
                        'contentType' => $attachment['contentType'],
                        'contentBytes' => $attachment['contentBytes'] ?? base64_encode(file_get_contents($attachment['path']))
                    ];
                }
            }

            $response = $this->client->request('POST', 'users/' . env('MICROSOFT_GRAPH_USER_EMAIL') . '/sendMail', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json'
                ],
                'json' => $message
            ]);

            Log::info('MicrosoftGraphService: Correo enviado exitosamente');
            return true;
        } catch (\Exception $e) {
            Log::error('MicrosoftGraphService: Error al enviar correo: ' . $e->getMessage());
            throw new \Exception('Error al enviar correo: ' . $e->getMessage());
        }
    }
}
