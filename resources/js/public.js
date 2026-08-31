import { initAOSIfNeeded } from "./lazy-aos";
import { initExavroMotionIfNeeded } from "./exavro-motion";

document.addEventListener("DOMContentLoaded", () => {
    initAOSIfNeeded();
    initExavroMotionIfNeeded();
});
