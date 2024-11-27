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

        const maxLength = 100; // Maximum characters allowed in the card text
    
        // Select all card text elements
        const cardTexts = document.querySelectorAll(".card-text");
    
        cardTexts.forEach(cardText => {
            // Function to truncate text and add ellipsis
            const truncateText = (text, maxLength) => {
                return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
            };
    
            // Initially truncate the text
            cardText.textContent = truncateText(cardText.textContent, maxLength);
    
            // Monitor for text changes in case of inspection/modification
            const observer = new MutationObserver(() => {
                cardText.textContent = truncateText(cardText.textContent, maxLength);
            });
    
            // Observe the card text for changes
            observer.observe(cardText, {
                characterData: true,
                subtree: true,
                childList: true
            });
        });
    
});
