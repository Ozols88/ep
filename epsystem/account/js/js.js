window.onload = function fixEmptyTableCells() {
    emptyCells = document.querySelectorAll(".cell .content[value='']");
    for (var i = 0; i < emptyCells.length; i++) {
        emptyCells[i].value = " ";
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
        for (i = 0; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].querySelector(td);
            y = rows[i + 1].querySelector(td);
            if (dir == "asc") {
                if (parseInt(x.innerHTML) > parseInt(y.innerHTML)) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
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
            input[arrayKey] = document.querySelector(key).value;
            arrayKey++;
        }
    }

    var value = [], txtValue = [], display;
    for (i = 0; i < rows.length; i++) {
        arrayKey = 0;
        display = true;
        for (key in fields) {
            if (fields.hasOwnProperty(key)) {
                value[key] = rows[i].querySelector(fields[key]);
                txtValue[key] = value[key].textContent || value[key].innerText;

                if (txtValue[key].indexOf(input[arrayKey]) > -1 && display !== false)
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
    var rows, inputId, inputProject, inputFloor, inputPreset;
    rows = document.getElementsByClassName("row");
    inputId = document.querySelector(".search-bar .input-id").value;
    inputProject = document.querySelector(".search-bar .input-name").value;
    inputFloor = document.querySelector(".search-bar .custom-select.input-floor .input-floor").value;
    inputPreset = document.querySelector(".search-bar .custom-select.input-preset .input-preset").value;

    for (i = 0; i < rows.length; i++) {
        id = rows[i].querySelector(".cell.id");
        project = rows[i].querySelector(".cell.name");
        floor = rows[i].querySelector(".cell.floor");
        preset = rows[i].querySelector(".cell.preset");

        txtValueId = id.textContent || id.innerText;
        txtValueProject = project.textContent || project.innerText;
        txtValueFloor = floor.textContent || floor.innerText;
        txtValuePreset = preset.textContent || preset.innerText;

        if (txtValueId.indexOf(inputId) > -1 && txtValueProject.indexOf(inputProject) > -1 && txtValueFloor.indexOf(inputFloor) > -1 && txtValuePreset.indexOf(inputPreset) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}