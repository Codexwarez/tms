import "./bootstrap";

import Alpine from "alpinejs";
import "flowbite";



window.Alpine = Alpine;
Alpine.start();

// Import Swiper
import Swiper from "swiper";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

// Initialize Swiper
const swiper = new Swiper(".mySwiper", {
    modules: [Navigation, Pagination, Autoplay],
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
