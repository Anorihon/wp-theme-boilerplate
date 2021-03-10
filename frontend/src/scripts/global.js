import '../styles/index.scss';

import './polyfills';

import AOS from 'aos/dist/aos';
// import { debounce } from './helpers';

$(function () {
    AOS.init({
        disable: "phone",
        duration: 1000,
        ease: 'ease-in-sine',
        once: true,
    });

    // ANCHOR Mobile menu
    let is_menu_open = false;
    let mob_menu_node = document.getElementById('mob-menu');
    let burgers = document.querySelectorAll('.burger');

    function toggle_mob_menu() {
        is_menu_open = !is_menu_open;

        if (is_menu_open === true) {
            mob_menu_node.classList.remove('show', 'hide');
            mob_menu_node.classList.add('show');
        } else {
            mob_menu_node.classList.add('hide');
        }
    }

    burgers.forEach(el => {
        el.addEventListener('click', toggle_mob_menu);
    });

    // ANCHOR Move up button
    $('#move-up').on('click', function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
});

window.addEventListener('load', AOS.refresh);