/* Help tooltips - START */
$(function(){
$(".someClass").tipTip({maxWidth: "auto", edgeOffset: 10});
});
/* Help tooltips - END */


/* Field type and options hide/show options box - START */
function typeList(){
    hideOptions(); 
}

function OnChange(dropdown){
    var selIndex  = dropdown.selectedIndex
    var typeValue = dropdown.options[selIndex].value
    if(typeValue == 'select'){
        showOptions();
    }
    if(typeValue != 'select'){
        hideOptions();
    }
}

function showOptions(){
        var options = document.getElementById('options');
        options.style.display = 'block';  
}

function hideOptions(){
        var options = document.getElementById('options');
        options.style.display = 'none';  
}
/* Field type and options hide/show options box - END */
