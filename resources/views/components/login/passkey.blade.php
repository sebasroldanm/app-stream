<meta name="csrf-token" content="{{ csrf_token() }}">

<button id="register-passkey">
    Registrar huella / Face ID
</button>

<script src="https://cdn.jsdelivr.net/npm/@laragear/webpass@2/dist/webpass.js"></script>

<script>

document.getElementById('register-passkey')
.addEventListener('click', async () => {

    try {

        // Verificar soporte WebAuthn
        if (Webpass.isUnsupported()) {

            alert('Tu navegador no soporta WebAuthn');

            return;
        }

        // Crear instancia
        const webpass = Webpass.create({
            findCsrfToken: true
        });

        // Registrar credential/passkey
        const { credential, success, error } = await webpass.attest(
            '/webauthn/register/options',
            '/webauthn/register'
        );

        console.log('credential:', credential);
        console.log('success:', success);
        console.log('error:', error);

        if (success) {

            alert('Passkey registrada correctamente');

            window.location.href = '/';

            return;
        }

        alert(error ?? 'No se pudo registrar la passkey');

    } catch (e) {

        console.error(e);

        alert('No se pudo registrar la passkey');
    }

});
</script>