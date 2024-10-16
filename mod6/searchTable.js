function searchTable() {
    var input, filter, table, tr, td, i, j, txtValue;

    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("dataGrid");
    tr = table.getElementsByTagName("tr");

    //looping
    for (i = 1; i < tr.length; i++) {//start at 1 to skip the header
        tr[i].style.display = "none"; //hid all rows initially
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) { //loop through each cell in the row
            if(td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1){
                    tr[i].style.display = ""; //show the row if a match is located
                    break;
                }
            }

        }
    }
}

const newLimit = document.getElementById('limitNum');

    newLimit.addEventListener('change', function() {
        const selectedValue = newLimit.value;
        
        changeLimit(selectedValue);
    });

function changeLimit(value) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'gridview.php?selectedValue=' + value, true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            console.log('Limit updated');
        } else {
            console.log('Error, limit not updated');
        }
    };
    xhr.send();
}