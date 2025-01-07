document.addEventListener('DOMContentLoaded', function () {
    const contents = document.querySelectorAll('.content');
    const counters = document.querySelectorAll('.stat-counter');

    // Function to check visibility of elements
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

    // Function to animate the counter from 0 to the target value
    function animateCounter(counter) {
        const target = parseInt(counter.getAttribute('data-target')); // Get the target value and convert to integer
        let current = 0; // Initialize current count
        const speed = 2000; // Total duration of the animation in milliseconds
        const increment = target / speed * 20; // How much to increase each step (assuming 20ms per frame)

        const updateCount = () => {
            current += increment;
            if (current < target) {
                counter.innerHTML = Math.ceil(current); // Update the counter, using Math.ceil to avoid decimals
                setTimeout(updateCount, 20); // Call update again after a short delay (20ms)
            } else {
                counter.innerHTML = target; // Ensure the counter reaches the target value
            }
        };
        updateCount();
    }

    // Function to check visibility of counters and trigger animation
    function checkCounters() {
        const windowHeight = window.innerHeight;

        counters.forEach(counter => {
            const rect = counter.getBoundingClientRect();
            if (rect.top < windowHeight && rect.bottom >= 0 && !counter.classList.contains('counted')) {
                animateCounter(counter); // Start animation if not already animated
                counter.classList.add('counted'); // Prevent re-triggering animation
            }
        });
    }

    // Event listeners for scroll and resize to trigger visibility and counters check
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

    // Text truncation for card texts
    const maxLength = 100; // Maximum characters allowed in the card text
    const cardTexts = document.querySelectorAll(".card-text");

    cardTexts.forEach(cardText => {
        const truncateText = (text, maxLength) => {
            return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
        };

        cardText.textContent = truncateText(cardText.textContent, maxLength);

        // Monitor for text changes using MutationObserver
        const observer = new MutationObserver(() => {
            cardText.textContent = truncateText(cardText.textContent, maxLength);
        });

        observer.observe(cardText, {
            characterData: true,
            subtree: true,
            childList: true
        });
    });
});
