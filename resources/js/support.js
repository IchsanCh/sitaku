import Pusher from "pusher-js";

// Diekspos global biar script inline di tiap blade (inbox.blade.php,
// chat.blade.php) bisa langsung pakai `new Pusher(...)` tanpa perlu
// masing-masing halaman jadi entry point/module Vite sendiri-sendiri.
window.Pusher = Pusher;
