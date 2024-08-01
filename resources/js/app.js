import "./bootstrap";

import "../sass/app.scss";
import * as bootstrap from "bootstrap";

import bs5 from 'bs5-toast'

import Alpine from "alpinejs";
import mask from "@alpinejs/mask";

Alpine.plugin(mask);

window.bs5 = bs5;
window.Alpine = Alpine;
window.bootstrap = bootstrap;

Alpine.start();


