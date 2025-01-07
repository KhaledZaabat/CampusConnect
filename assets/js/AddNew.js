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