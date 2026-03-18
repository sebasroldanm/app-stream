<div class="container mt-5">
    <!-- Introducción -->
    <div class="text-center mb-4">
        <h1>{{ __('contact.title') }}</h1>
        <p class="lead">{{ __('contact.subtitle') }}</p>
    </div>

    <!-- Formulario de Contacto -->
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('contact.name') }}</label>
                    <input type="text" class="form-control" id="name" placeholder="{{ __('contact.name_placeholder') }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('contact.email') }}</label>
                    <input type="email" class="form-control" id="email" placeholder="{{ __('contact.email_placeholder') }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">{{ __('contact.message') }}</label>
                    <textarea class="form-control" id="message" rows="5" placeholder="{{ __('contact.message_placeholder') }}" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('contact.send') }}</button>
            </form>
        </div>
    </div>

    <!-- Información de Contacto -->
    <div class="text-center mt-5">
        <h2>{{ __('contact.info_title') }}</h2>
        <p><strong>{{ __('contact.phone') }}:</strong> +123 456 7890</p>
        <p><strong>{{ __('contact.email_label') }}:</strong> contacto@tusitio.com</p>
        <p><strong>{{ __('contact.address') }}:</strong> Calle Ficticia 123, Ciudad, País</p>
    </div>
</div>
