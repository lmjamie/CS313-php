function been_clicked() {
    alert("Clicked!");
}

function change_color(id){
    var div1 = document.getElementById("div1");
    var divColor = document.getElementById(id).value;
    div1.style.backgroundColor = divColor;
}
