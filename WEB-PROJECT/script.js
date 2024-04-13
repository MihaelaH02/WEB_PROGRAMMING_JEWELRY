function addNewSection(content) {
    var newSection = document.createElement('section');
    newSection.innerHTML = '<div class="invalid-data">'+content+'</div>';
    document.getElementById('nav_guests').insertAdjacentElement('afterend',newSection);
}

function replaceSection() {
    var oldSection = document.getElementById('find-order');
    var newSection = document.getElementById('order-details');
    var container = document.getElementById('container-replace-data');
    container.replaceChild(newSection, oldSection);
}

function handleSelectPayment() {
    var selectedOption = document.getElementById("typepay").value;
    var cardFields = document.getElementsByClassName("card-info");
    for (var i = 0; i < cardFields.length; i++){
        cardFields[i].disabled = (selectedOption == 1) ? true : false;
    }
}