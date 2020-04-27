function clickText(){
    alert("Clicked!");
}
function setColor(){
    alert("change color!");
    document.getElementById('div1').style.backgroundColor = document.getElementById('setColor').value;
}

function toggleVis(){
    $(document).ready(function(){
        $("vis").click(function(){
          $("#div3").hide();
        });
      });
}