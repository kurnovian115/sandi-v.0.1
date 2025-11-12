import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import 'flowbite';

import Swal from 'sweetalert2';

// Optional: export biar bisa dipakai di Blade inline <script>
window.Swal = Swal;
