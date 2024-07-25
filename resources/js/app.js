import "./bootstrap";

import "../sass/app.scss";
import * as bootstrap from "bootstrap";

import Alpine from "alpinejs";
import mask from '@alpinejs/mask'

Alpine.plugin(mask)

window.Alpine = Alpine;
window.bootstrap = bootstrap;

Alpine.start();
