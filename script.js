function toggleColumns() {
    var tdElements = document.querySelectorAll('td');
    var displayStyle = tdElements[0].style.display === 'none' ? 'table-cell' : 'none';
    for (var i = 0; i < tdElements.length; i++) {
      tdElements[i].style.display = displayStyle;
    }
  }
  