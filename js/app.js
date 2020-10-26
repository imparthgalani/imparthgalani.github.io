/* =================== Start Responsiv Navbar Js =================== */

$(document).ready(function() {
    $(window).on('scroll', function() {
        if ($(window).scrollTop()) {
            $(".nav-wrapper").addClass('nav-wrapper-background');
        } else {
            $(".nav-wrapper").removeClass('nav-wrapper-background');
        }
    });
});

/* ==================== End Responsiv Navbar Js ==================== */

/* =============== End Responsiv Mobile hamburger Js =============== */

window.addEventListener('resize', function() {
    addRequiredClass();
})

function addRequiredClass() {
    if (window.innerWidth < 860) {
        document.body.classList.add('mobile')
    } else {
        document.body.classList.remove('mobile')
    }
}
window.onload = addRequiredClass

let hamburger = document.querySelector('.hamburger')
let mobileNav = document.querySelector('.nav-list')

let bars = document.querySelectorAll('.hamburger span')

let isActive = false

hamburger.addEventListener('click', function() {
    mobileNav.classList.toggle('open')
    if (!isActive) {
        bars[0].style.transform = 'rotate(45deg)'
        bars[1].style.opacity = '0'
        bars[2].style.transform = 'rotate(-45deg)'
        isActive = true
    } else {
        bars[0].style.transform = 'rotate(0deg)'
        bars[1].style.opacity = '1'
        bars[2].style.transform = 'rotate(0deg)'
        isActive = false
    }

})

/* =============== End Responsiv hamburger Js =============== */

/* ================== Start scroll-Top Js =================== */

const scroll_top = document.querySelector('.scroll_top');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 100) {
        scroll_top.classList.add('active');
    } else {
        scroll_top.classList.remove('active');
    }
})

/* ================== End scroll-Top Js =================== */

/* ================== Start Lite & Dark - mode Js =================== */


/* ================== End Lite & Dark - mode Js =================== */