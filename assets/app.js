/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
// assets/app.js
import $ from 'jquery'; // Import jQuery
import 'bootstrap'; // Import Bootstrap JS
//import './bootstrap.js';
import 'bootstrap/dist/css/bootstrap.min.css'; // Import Bootstrap CSS

// jQuery is available globally thanks to the "autoProvidejQuery" configuration
$(document).ready(function() {
    console.log('Hello from jQuery and Bootstrap!');
});
