document.addEventListener('DOMContentLoaded', function () {
    const contents = document.querySelectorAll('.content');
    const counters = document.querySelectorAll('.stat-counter');

    function checkVisibility() {
        const windowHeight = window.innerHeight;

        contents.forEach(content => {
            const rect = content.getBoundingClientRect();
            if (rect.top < windowHeight && rect.bottom >= 0) {
                content.classList.add('visible');
            } else {
                content.classList.remove('visible');
            }
        });
    }

    function animateCounter(counter) {
        const target = +counter.getAttribute('data-target');
        const speed = 200;
        const updateCount = () => {
            const current = +counter.innerText;
            const increment = target / speed;

            if (current < target) {
                counter.innerText = Math.ceil(current + increment);
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    }

    function checkCounters() {
        const windowHeight = window.innerHeight;

        counters.forEach(counter => {
            const rect = counter.getBoundingClientRect();
            if (rect.top < windowHeight && rect.bottom >= 0 && !counter.classList.contains('counted')) {
                animateCounter(counter);
                counter.classList.add('counted');
            }
        });
    }

    window.addEventListener('scroll', () => {
        checkVisibility();
        checkCounters();
    });

    window.addEventListener('resize', () => {
        checkVisibility();
        checkCounters();
    });
    
    // Initial check
    checkVisibility();
    checkCounters();
});
