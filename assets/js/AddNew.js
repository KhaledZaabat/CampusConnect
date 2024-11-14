document.addEventListener('DOMContentLoaded', function () {
    const addMediaBtn = document.getElementById('add-media-btn');
    const addTableBtn = document.getElementById('add-table-btn');
    const mediaFileInput = document.getElementById('media-file-input');
    const boldBtn = document.querySelector('[data-command="bold"]');
    const italicBtn = document.querySelector('[data-command="italic"]');
    const underlineBtn = document.querySelector('[data-command="underline"]');
    const linkBtn = document.getElementById('add-link-btn');
    const colorBtn = document.getElementById('color-btn');
    const newsContent = document.getElementById('news-content');
    const linkModal = document.getElementById('linkModal');
    const linkModalClose = document.getElementById('linkModalClose');
    const linkSubmit = document.getElementById('linkSubmit');
    const tableModal = document.getElementById('tableModal');
    const tableModalClose = document.getElementById('tableModalClose');
    const tableSubmit = document.getElementById('tableSubmit');
    const colorModal = document.getElementById('colorModal');
    const colorModalClose = document.getElementById('colorModalClose');
    const colorSubmit = document.getElementById('colorSubmit');
    const linkUrl = document.getElementById('linkUrl');
    const tableRows = document.getElementById('tableRows');
    const tableCols = document.getElementById('tableCols');
    const colorInput = document.getElementById('colorPicker');

    let savedRange;
    let isContentChanged = false;

    // Save the cursor position in the editable area
    newsContent.addEventListener('mouseup', saveCursorPosition);
    newsContent.addEventListener('keyup', saveCursorPosition);

    function saveCursorPosition() {
        const sel = window.getSelection();
        if (sel.rangeCount > 0) {
            savedRange = sel.getRangeAt(0);
        }
    }

    // Restore cursor position
    function restoreCursorPosition() {
        if (savedRange) {
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(savedRange);
        }
    }

    // Text formatting event listeners
    boldBtn.addEventListener('click', function () {
        document.execCommand('bold');
    });

    italicBtn.addEventListener('click', function () {
        document.execCommand('italic');
    });

    underlineBtn.addEventListener('click', function () {
        document.execCommand('underline');
    });

    // Link insertion event listeners
    linkBtn.addEventListener('click', function () {
        saveCursorPosition();
        linkModal.style.display = 'block';
        linkModal.classList.add('show');
    });

    linkModalClose.addEventListener('click', function () {
        linkModal.style.display = 'none';
        linkModal.classList.remove('show');
    });

    linkSubmit.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent form submission
        restoreCursorPosition();
        const url = linkUrl.value;
        if (url) {
            document.execCommand('createlink', false, url);
        }
        linkModal.style.display = 'none';
        linkModal.classList.remove('show');
    });

    // Table insertion event listeners
    addTableBtn.addEventListener('click', function () {
        saveCursorPosition();
        tableModal.style.display = 'block';
        tableModal.classList.add('show');
    });

    tableModalClose.addEventListener('click', function () {
        tableModal.style.display = 'none';
        tableModal.classList.remove('show');
    });

    tableSubmit.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent form submission
        restoreCursorPosition();
        const rows = tableRows.value;
        const cols = tableCols.value;
        if (rows && cols) {
            const table = document.createElement('table');
            table.classList.add('styled-table'); // Add class for styling
            table.style.width = '100%';

            for (let i = 0; i < rows; i++) {
                const tr = document.createElement('tr');
                for (let j = 0; j < cols; j++) {
                    if (i === 0) {
                        const th = document.createElement('th');
                        th.appendChild(document.createTextNode('Header ' + (j + 1)));
                        tr.appendChild(th);
                    } else {
                        const td = document.createElement('td');
                        td.appendChild(document.createTextNode('Cell ' + (i + 1) + ',' + (j + 1)));
                        tr.appendChild(td);
                    }
                }
                table.appendChild(tr);
            }
            insertAtCursor(table);  // Insert table at the cursor position
        }
        tableModal.style.display = 'none';
        tableModal.classList.remove('show');
    });

    // Color picker event listeners
    colorBtn.addEventListener('click', function () {
        saveCursorPosition();
        colorModal.style.display = 'block';
        colorModal.classList.add('show');
    });

    colorModalClose.addEventListener('click', function () {
        colorModal.style.display = 'none';
        colorModal.classList.remove('show');
    });

    colorSubmit.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent form submission
        restoreCursorPosition();
        const color = colorInput.value;
        if (color) {
            document.execCommand('foreColor', false, color);
        }
        colorModal.style.display = 'none';
        colorModal.classList.remove('show');
    });

    // Media insertion event listeners
    addMediaBtn.addEventListener('click', function () {
        mediaFileInput.click();
    });

    mediaFileInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const mediaUrl = e.target.result;
            let mediaElement;

            if (file.type.startsWith('image/')) {
                mediaElement = document.createElement('img');
                mediaElement.src = mediaUrl;
                mediaElement.alt = file.name;
                mediaElement.style.maxWidth = '70%';
                mediaElement.style.height = 'auto';
                mediaElement.style.display = 'block';
                mediaElement.style.margin = '10px auto'; // Centers the image
            } else if (file.type.startsWith('video/')) {
                mediaElement = document.createElement('video');
                mediaElement.controls = true;
                mediaElement.style.maxWidth = '70%';
                mediaElement.style.height = 'auto';
                mediaElement.style.display = 'block'; // Centers the video
                mediaElement.style.margin = '10px auto'; // Centers the image


                const source = document.createElement('source');
                source.src = mediaUrl;
                source.type = file.type;
                mediaElement.appendChild(source);
            }

            insertAtCursor(mediaElement);
        };

        reader.readAsDataURL(file);
    });

    // Function to insert element at the cursor position
    function insertAtCursor(element) {
        if (savedRange) {
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(savedRange);

            const range = savedRange;
            range.deleteContents();

            const frag = document.createDocumentFragment();
            frag.appendChild(element);

            range.insertNode(frag);

            // Move the cursor after the inserted element
            range.setStartAfter(element);
            range.setEndAfter(element);
            sel.removeAllRanges();
            sel.addRange(range);
        }
    }

    function restoreCursorPosition() {
        if (savedRange) {
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(savedRange);
        }
    }

    // Mark content as changed
    newsContent.addEventListener('input', function () {
        isContentChanged = true;
    });

    // Function to show SweetAlert before page unload
    function showUnloadAlert(event) {
        if (isContentChanged && !isConfirmed) {
            event.preventDefault();
            event.returnValue = '';
            Swal.fire({
                title: 'Are you sure?',
                text: "You have unsaved changes. Do you really want to leave?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, leave',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    isConfirmed = true;
                    window.removeEventListener('beforeunload', showUnloadAlert);
                    window.location.reload();
                }
            });
            return '';
        }
    }

    window.addEventListener('beforeunload', showUnloadAlert);

    // Close modals when clicking outside of them
    window.addEventListener('click', function(event) {
        if (event.target == linkModal) {
            linkModal.style.display = 'none';
            linkModal.classList.remove('show');
        }
        if (event.target == tableModal) {
            tableModal.style.display = 'none';
            tableModal.classList.remove('show');
        }
        if (event.target == colorModal) {
            colorModal.style.display = 'none';
            colorModal.classList.remove('show');
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const newsContent = document.getElementById('news-content');

    // Set placeholder text
    function setPlaceholder() {
        if (newsContent.innerHTML.trim() === '') {
            newsContent.innerHTML = 'Type your content here...';
            newsContent.style.color = '#999';
        }
    }

    // Remove placeholder on focus
    newsContent.addEventListener('focus', function () {
        if (newsContent.innerHTML === 'Type your content here...') {
            newsContent.innerHTML = '';
            newsContent.style.color = '#000'; // Reset text color
        }
    });

    // Restore placeholder if empty on blur
    newsContent.addEventListener('blur', function () {
        setPlaceholder();
    });

    // Ensure placeholder on input
    newsContent.addEventListener('input', function () {
        isContentChanged = true;
        if (newsContent.innerHTML.trim() === '') {
            setPlaceholder();
        } else {
            newsContent.style.color = '#000'; // Reset text color
        }
    });

    // Initialize placeholder
    setPlaceholder();

    // Save the cursor position in the editable area
    newsContent.addEventListener('mouseup', saveCursorPosition);
    newsContent.addEventListener('keyup', saveCursorPosition);

    function saveCursorPosition() {
        const sel = window.getSelection();
        if (sel.rangeCount > 0) {
            savedRange = sel.getRangeAt(0);
        }
    }

    // Restore cursor position
    function restoreCursorPosition() {
        if (savedRange) {
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(savedRange);
        }
    }

    // Mark content as changed
    newsContent.addEventListener('input', function () {
        isContentChanged = true;
    });

});

document.addEventListener('DOMContentLoaded', function () {
    const newsForm = document.getElementById('news-form');
    const newsTitle = document.getElementById('news-title');
    const newsContent = document.getElementById('news-content');
    const titleError = document.getElementById('title-error');
    const contentError = document.getElementById('content-error');

    newsForm.addEventListener('submit', function (event) {
        let isValid = true;

        // Validate title
        if (newsTitle.value.trim() === '') {
            newsTitle.classList.add('input-error');
            titleError.style.display = 'block';
            isValid = false;
        } else {
            newsTitle.classList.remove('input-error');
            titleError.style.display = 'none';
        }

        // Validate content
        if (newsContent.textContent.trim() === '') {
            newsContent.classList.add('input-error');
            contentError.style.display = 'block';
            isValid = false;
        } else {
            newsContent.classList.remove('input-error');
            contentError.style.display = 'none';
        }

        // Prevent form submission if not valid
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Placeholder functionality
    function setPlaceholder() {
        if (newsContent.innerHTML.trim() === '') {
            newsContent.innerHTML = 'Type your content here...';
            newsContent.style.color = '#999';
        }
    }

    newsContent.addEventListener('focus', function () {
        if (newsContent.innerHTML === 'Type your content here...') {
            newsContent.innerHTML = '';
            newsContent.style.color = '#000'; // Reset text color
        }
    });

    newsContent.addEventListener('blur', function () {
        setPlaceholder();
    });

    newsContent.addEventListener('input', function () {
        isContentChanged = true;
        if (newsContent.innerHTML.trim() === '') {
            setPlaceholder();
        } else {
            newsContent.style.color = '#000'; // Reset text color
        }
    });

    // Initialize placeholder
    setPlaceholder();

    // Save the cursor position in the editable area
    newsContent.addEventListener('mouseup', saveCursorPosition);
    newsContent.addEventListener('keyup', saveCursorPosition);

    function saveCursorPosition() {
        const sel = window.getSelection();
        if (sel.rangeCount > 0) {
            savedRange = sel.getRangeAt(0);
        }
    }

    function restoreCursorPosition() {
        if (savedRange) {
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(savedRange);
        }
    }

   
});


document.addEventListener('DOMContentLoaded', function () {
    const newsForm = document.getElementById('news-form');
    const newsTitle = document.getElementById('news-title');
    const newsContent = document.getElementById('news-content');
    const titleError = document.getElementById('title-error');
    const contentError = document.getElementById('content-error');

    newsForm.addEventListener('submit', function (event) {
        let isValid = true;

        // Validate title
        if (newsTitle.value.trim() === '') {
            newsTitle.classList.add('input-error');
            titleError.style.display = 'block';
            isValid = false;
        } else {
            newsTitle.classList.remove('input-error');
            titleError.style.display = 'none';
        }

        // Validate content
        if (newsContent.textContent.trim() === '' || newsContent.textContent.trim() === 'Type your content here...') {
            newsContent.classList.add('input-error');
            contentError.style.display = 'block';
            isValid = false;
        } else {
            newsContent.classList.remove('input-error');
            contentError.style.display = 'none';
        }

        // Prevent form submission if not valid
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Placeholder functionality
    function setPlaceholder() {
        if (newsContent.innerHTML.trim() === '' || newsContent.innerHTML.trim() === 'Type your content here...') {
            newsContent.innerHTML = 'Type your content here...';
            newsContent.style.color = '#999';
        }
    }

    newsContent.addEventListener('focus', function () {
        if (newsContent.innerHTML === 'Type your content here...') {
            newsContent.innerHTML = '';
            newsContent.style.color = '#000'; // Reset text color
        }
    });

    newsContent.addEventListener('blur', function () {
        setPlaceholder();
    });

    newsContent.addEventListener('input', function () {
        if (newsContent.innerHTML.trim() === '') {
            setPlaceholder();
        } else {
            newsContent.style.color = '#000'; // Reset text color
        }
    });

    // Initialize placeholder
    setPlaceholder();

    // Save the cursor position in the editable area
    newsContent.addEventListener('mouseup', saveCursorPosition);
    newsContent.addEventListener('keyup', saveCursorPosition);

    function saveCursorPosition() {
        const sel = window.getSelection();
        if (sel.rangeCount > 0) {
            savedRange = sel.getRangeAt(0);
        }
    }

    function restoreCursorPosition() {
        if (savedRange) {
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(savedRange);
        }
    }

    // Additional existing scripts...

    let isContentChanged = false;

    // Function to show SweetAlert before page unload
    function showUnloadAlert(event) {
        if (isContentChanged && !isConfirmed) {
            event.preventDefault();
            event.returnValue = '';
            Swal.fire({
                title: 'Are you sure?',
                text: "You have unsaved changes. Do you really want to leave?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, leave',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    isConfirmed = true;
                    window.removeEventListener('beforeunload', showUnloadAlert);
                    window.location.reload();
                }
            });
            return '';
        }
    }

    window.addEventListener('beforeunload', showUnloadAlert);

    // Close modals when clicking outside of them
    window.addEventListener('click', function(event) {
        if (event.target == linkModal) {
            linkModal.style.display = 'none';
            linkModal.classList.remove('show');
        }
        if (event.target == tableModal) {
            tableModal.style.display = 'none';
            tableModal.classList.remove('show');
        }
        if (event.target == colorModal) {
            colorModal.style.display = 'none';
            colorModal.classList.remove('show');
        }
    });
});



