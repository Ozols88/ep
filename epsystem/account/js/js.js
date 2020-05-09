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
        th[i].style.background = '#F0EEEA';
    }
    document.querySelector(tr).style.background = '#F5B82E';
    window.scrollTo(0, 0);
}

function searchTable() {
    var rows, inputId, inputProject, inputType, inputClient;
    rows = document.getElementsByClassName("row");
    inputId = document.querySelector(".search-bar .input-id").value;
    inputProject = document.querySelector(".search-bar .input-name").value;
    inputDivision = document.querySelector(".search-bar .custom-select.input-division .input-division").value;
    inputPreset = document.querySelector(".search-bar .custom-select.input-preset .input-preset").value;

    console.log(rows);
    for (i = 0; i < rows.length; i++) {
        id = rows[i].querySelector(".cell.id");
        project = rows[i].querySelector(".cell.name");
        division = rows[i].querySelector(".cell.division");
        preset = rows[i].querySelector(".cell.preset");

        txtValueId = id.textContent || id.innerText;
        txtValueProject = project.textContent || project.innerText;
        txtValueDivision = division.textContent || division.innerText;
        txtValuePreset = preset.textContent || preset.innerText;

        if (txtValueId.indexOf(inputId) > -1 && txtValueProject.indexOf(inputProject) > -1 && txtValueDivision.indexOf(inputDivision) > -1 && txtValuePreset.indexOf(inputPreset) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}