function clickText(){
    alert("Clicked!");
}
function setColor(){
    alert("change color!");
    document.getElementById('div1').style.backgroundColor = document.getElementById('color').value;
}
function setColorJQ(){
    var color = document.getElementById('color').value;
    $("#div1").css("background-color", color);
}


    $(document).ready(function(){
        $("#vis").click(function(){
          $("#div3").fadeToggle("slow");
        });
      });
