$(document).ready(function(){
    function openForm() {
        document.getElementById("popupForm").style.display = "block";
    }
    function closeForm() {
        document.getElementById("popupForm").style.display = "none";
    }
    $('button[class*=btnModif]').each(function(){
        //ny class tsirairay eto manko btnModiL1/f1, btnModiL2/f2....
        //de alaina le classe sy id farany iny satria iny ny classe sy id anle matiere
        var classIdMatiere = $(this).attr('class').slice(8);
        
        //alaina le matiere mifanandrify amle btn modif
        //satria anatina <td> zay vo <button>, donc miakatra eo am <td> izay vo maka ny sibling an
        var matiere = $(this).parent().siblings('.nom').text();

        //alaina ny nom du responsable
        var nomResp = $(this).parent().siblings('.resp').text().toLowerCase();

        //clickena le btn
        $(this).click(function(){
            //soloina ny attribut action any
            $('form').attr('value', '/matiere/modifier/' + classIdMatiere);

            //valeur par défaut de l'input 
            $('#nomMatiere').val(matiere);
            $('select').children('option[value*='+nomResp+']').attr('selected', 'selected');
            openForm();
        });
    })
    $('#btnClose').click(closeForm);

    $('#btnSave').click(sendData);

    function sendData() {
        var data = {
            nom: $('#nomMatiere').val(),
            resp: $('#resp').val(),
        };
    
        var xhr = new XMLHttpRequest();
    
        //👇 set the PHP page you want to send data to
        xhr.open("POST", $('form').attr('value'), true);
        xhr.setRequestHeader("Content-Type", "application/json");
    
        //👇 what to do when you receive a response
        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                location.reload();
            }
        };
    
        //👇 send the data
        xhr.send(JSON.stringify(data));
    }
})