function removeItem(str, file){
    return file.replace(str,"");
}
function validateForm() {
    var x = document.forms["orderForm"]["name"].value;
    if (x == "") {
      alert("Name must be filled out");
      return false;
    }
  }

  function remove(i) { 
    //document.getElementsByTagName("tr")[i-1].remove(); 

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            // document.getElementById("demo").innerHTML = xhttp.responseText;
            alert(i);
        }
    };
    xhttp.open("GET", "delete.php?line=" + i, true);
    xhttp.send();
}