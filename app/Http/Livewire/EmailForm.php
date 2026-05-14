<?php

namespace App\Http\Livewire;

use App\Services\MicrosoftGraphService;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmailForm extends Component
{
    use WithFileUploads;

    public $to;
    public $subject;
    public $body;
    public $attachments = [];

    public $success = false;
    public $error = null;

    public function render()
    {
        return view('livewire.email-form');
    }

    public function sendEmail()
    {
        $this->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max
        ]);

        try {
            $graphService = new MicrosoftGraphService();

            $processedAttachments = [];
            foreach ($this->attachments as $attachment) {
                $processedAttachments[] = [
                    'name' => $attachment->getClientOriginalName(),
                    'contentType' => $attachment->getMimeType(),
                    'path' => $attachment->getRealPath()
                ];
            }

            $graphService->sendMail(
                $this->subject,
                $this->body,
                $this->to,
                $processedAttachments
            );

            $this->success = true;
            $this->reset(['to', 'subject', 'body', 'attachments']);
            $this->error = null;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->success = false;
        }
    }
}
