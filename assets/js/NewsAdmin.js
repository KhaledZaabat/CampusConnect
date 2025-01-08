document.addEventListener('DOMContentLoaded', function() {
    const newsContainer = document.getElementById('news-container');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const paginationControls = document.getElementById('pagination-controls');
    
    const itemsPerPage = 5;
    let currentPage = 1;
    let originalItems = [];
    let filteredItems = [];

    // Store original news items with their complete content
    document.querySelectorAll('.news-item').forEach(item => {
        originalItems.push({
            element: item.cloneNode(true),
            searchContent: (item.textContent || '').toLowerCase()
        });
    });
    filteredItems = [...originalItems];

    function displayNews(items, page) {
        newsContainer.innerHTML = '';
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paginatedItems = items.slice(start, end);

        paginatedItems.forEach(item => {
            newsContainer.appendChild(item.element.cloneNode(true));
        });

       
    }

    function createPaginationButton(text, isActive = false, clickHandler) {
        const button = document.createElement('button');
        button.textContent = text;
        button.className = isActive ? 'active' : '';
        button.onclick = clickHandler;
        return button;
    }

    function updatePagination(items) {
        const pageCount = Math.ceil(items.length / itemsPerPage);
        paginationControls.innerHTML = '';

        if (pageCount <= 1) return;

        if (currentPage > 1) {
            paginationControls.appendChild(
                createPaginationButton('Previous', false, () => {
                    currentPage--;
                    updateDisplay();
                })
            );
        }

        // Show limited page numbers with ellipsis
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(pageCount, startPage + 4);
        
        if (startPage > 1) {
            paginationControls.appendChild(createPaginationButton('1', false, () => {
                currentPage = 1;
                updateDisplay();
            }));
            if (startPage > 2) paginationControls.appendChild(document.createTextNode('...'));
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationControls.appendChild(
                createPaginationButton(i.toString(), i === currentPage, () => {
                    currentPage = i;
                    updateDisplay();
                })
            );
        }

        if (endPage < pageCount) {
            if (endPage < pageCount - 1) paginationControls.appendChild(document.createTextNode('...'));
            paginationControls.appendChild(
                createPaginationButton(pageCount.toString(), false, () => {
                    currentPage = pageCount;
                    updateDisplay();
                })
            );
        }

        if (currentPage < pageCount) {
            paginationControls.appendChild(
                createPaginationButton('Next', false, () => {
                    currentPage++;
                    updateDisplay();
                })
            );
        }
    }

    function updateDisplay() {
        if (filteredItems.length === 0) {
            newsContainer.innerHTML = '<div class="no-results">No news items found.</div>';
            paginationControls.innerHTML = '';
        } else {
            displayNews(filteredItems, currentPage);
            updatePagination(filteredItems);
        }
    }

    function handleSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            filteredItems = [...originalItems];
        } else {
            filteredItems = originalItems.filter(item => 
                item.searchContent.includes(searchTerm)
            );
        }
        
        currentPage = 1;
        updateDisplay();
    }

    let searchTimeout;
    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(handleSearch, 300);
    });
    
    searchButton.addEventListener('click', handleSearch);

    // Initial display
    updateDisplay();

    
    

});

document.addEventListener('DOMContentLoaded', function() {
    const newsContainer = document.getElementById('news-container');

    newsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('Delete')) {
            e.preventDefault();
            const id = e.target.getAttribute('data-id');
            handleDelete(id);
        }
    });

    function handleDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('id', id);

                fetch('deleteNews.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Deleted!', 'News has been deleted.', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error!', 'Something went wrong', 'error');
                });
            }
        });
    }
});