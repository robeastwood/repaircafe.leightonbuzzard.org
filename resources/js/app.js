import "./bootstrap";
import "../css/app.css";

import 'tw-elements';

import Alpine from "alpinejs";
import focus from "@alpinejs/focus";
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
