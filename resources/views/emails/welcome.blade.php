@component('mail::message')
# ¡Bienvenido a la Mueblería Virtual ISSSTEZAC, {{ $name }}! 🎉

Gracias por registrarte en nuestra tienda. Ahora puedes explorar nuestros productos y aprovechar ofertas exclusivas.

@component('mail::button', ['url' => url('/')])
Explorar Tienda
@endcomponent

Si tienes alguna pregunta, no dudes en contactarnos.

Saludos,<br>
**ISSSTEZAC**
@endcomponent
