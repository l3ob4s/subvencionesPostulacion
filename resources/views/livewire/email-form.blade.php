<div>
    @if ($success)
        <div class="alert alert-success">
            El correo se ha enviado correctamente.
        </div>
    @endif

    @if ($error)
        <div class="alert alert-danger">
            Error al enviar el correo: {{ $error }}
        </div>
    @endif

    <form wire:submit.prevent="sendEmail">
        <div class="mb-3">
            <label for="to" class="form-label">Destinatario:</label>
            <input type="email" class="form-control" id="to" wire:model="to">
            @error('to') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Asunto:</label>
            <input type="text" class="form-control" id="subject" wire:model="subject">
            @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Mensaje:</label>
            <textarea class="form-control" id="body" wire:model="body" rows="5"></textarea>
            @error('body') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="attachments" class="form-label">Adjuntos:</label>
            <input type="file" class="form-control" id="attachments" wire:model="attachments" multiple>
            @error('attachments.*') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Enviar correo</button>
    </form>
</div>
