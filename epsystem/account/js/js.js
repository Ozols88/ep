window.onload = function fixEmptyTableCells() {
    emptyCells = document.querySelectorAll(".cell .content[value='']");
    for (var i = 0; i < emptyCells.length; i++) {
        emptyCells[i].value = " ";
    }
    var tooltips = document.querySelectorAll(".container-button .hover-text");
    window.onmousemove = function (e) {
        var x = (e.clientX + 20) + 'px',
            y = (e.clientY + 20) + 'px';
        for (var i = 0; i < tooltips.length; i++) {
            tooltips[i].style.top = y;
            tooltips[i].style.left = x;
        }
    }
}

function sortTable(tr, td) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementsByClassName("table")[0];
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.getElementsByClassName("row");
        if (isNaN(parseFloat(rows[0].querySelector(td).getAttribute("value"))))
            for (i = 0; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].querySelector(td);
                y = rows[i + 1].querySelector(td);
                console.log(parseFloat(x.innerHTML), parseFloat(y.innerHTML));
                if (dir == "asc") {
                    if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        else
            for (i = 0; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].querySelector(td).getAttribute("value");
                y = rows[i + 1].querySelector(td).getAttribute("value");
                if (dir == "asc") {
                    if (parseFloat(x) > parseFloat(y)) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (parseFloat(x) < parseFloat(y)) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
    th = document.getElementsByClassName("head");
    for (var i = 0; i < th.length; i++) {
        th[i].style.background = '';
    }
    document.querySelector(tr).style.background = '#F5B82E';
    window.scrollTo(0, 0);
}

function sortDates(tr, td, date) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementsByClassName("table")[0];
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.getElementsByClassName("row");
        if (isNaN(parseInt(rows[0].querySelector(td).getAttribute("value"))))
            for (i = 0; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].querySelector(date).getAttribute("value");
                y = rows[i + 1].querySelector(date).getAttribute("value");
                console.log(x, y);
                if (dir == "asc") {
                    if (x > y) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x < y) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        else
            for (i = 0; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].querySelector(date).getAttribute("value");
                y = rows[i + 1].querySelector(date).getAttribute("value");
                if (dir == "asc") {
                    if (x > y) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x < y) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
    th = document.getElementsByClassName("head");
    for (var i = 0; i < th.length; i++) {
        th[i].style.background = '';
    }
    document.querySelector(tr).style.background = '#F5B82E';
    window.scrollTo(0, 0);
}

function sortTime(tr, td) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementsByClassName("table")[0];
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.getElementsByClassName("row");
        if (isNaN(parseInt(rows[0].querySelector(td).getAttribute("value"))))
            for (i = 0; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].querySelector(td).innerHTML;
                y = rows[i + 1].querySelector(td).innerHTML;
                if (dir == "asc") {
                    if (x.localeCompare(y) === 1) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.localeCompare(y) === -1) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        else
            for (i = 0; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].querySelector(td).getAttribute("value");
                y = rows[i + 1].querySelector(td).getAttribute("value");
                if (dir == "asc") {
                    if (x.localeCompare(y) === 1) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.localeCompare(y) === -1) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
    th = document.getElementsByClassName("head");
    for (var i = 0; i < th.length; i++) {
        th[i].style.background = '';
    }
    document.querySelector(tr).style.background = '#F5B82E';
    window.scrollTo(0, 0);
}

function searchTable(fields, selectElement) {
    var input = [], arrayKey = 0, rows = document.getElementsByClassName("row");
    for (key in fields) {
        if (fields.hasOwnProperty(key)) {
            input[arrayKey] = document.querySelector(key).value.toLowerCase();
            arrayKey++;
        }
    }

    var val = [], txtVal = [], display;
    for (i = 0; i < rows.length; i++) {
        arrayKey = 0;
        display = true;
        for (key in fields) {
            if (fields.hasOwnProperty(key)) {
                val[key] = rows[i].querySelector(fields[key]);
                txtVal[key] = val[key].textContent.toLowerCase() || val[key].innerText.toLowerCase() || val[key].getElementsByTagName("input")[0].getAttribute("value").toLowerCase();

                if (txtVal[key].indexOf(input[arrayKey]) > -1 && display !== false)
                    display = true;
                else
                    display = false;
                arrayKey++;
            }
        }
        if (display === true) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }

    if (typeof selectElement !== 'undefined') {
        var customSelectElement = selectElement.parentNode;
        if (selectElement.value !== "")
            customSelectElement.classList.add("active");
        else
            customSelectElement.classList.remove("active");
    }
}

function searchTableOld() {
    var rows, inputId, inputProject, inputProduct, inputPreset;
    rows = document.getElementsByClassName("row");
    inputId = document.querySelector(".search-bar .input-id").value;
    inputProject = document.querySelector(".search-bar .input-name").value;
    inputProduct = document.querySelector(".search-bar .custom-select.input-product .input-product").value;
    inputPreset = document.querySelector(".search-bar .custom-select.input-preset .input-preset").value;

    for (i = 0; i < rows.length; i++) {
        id = rows[i].querySelector(".cell.id");
        project = rows[i].querySelector(".cell.name");
        product = rows[i].querySelector(".cell.product");
        preset = rows[i].querySelector(".cell.preset");

        txtValueId = id.textContent || id.innerText;
        txtValueProject = project.textContent || project.innerText;
        txtValueProduct = product.textContent || product.innerText;
        txtValuePreset = preset.textContent || preset.innerText;

        if (txtValueId.indexOf(inputId) > -1 && txtValueProject.indexOf(inputProject) > -1 && txtValueProduct.indexOf(inputProduct) > -1 && txtValuePreset.indexOf(inputPreset) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}