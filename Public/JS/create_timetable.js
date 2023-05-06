$(document).ready(function(){
    var matieres = $('#matieres').val();
    matieres = matieres.split(';');

    //pour chaque <tr>, misy anle oe premiere heure, deuxieme....
    $('tr').each(function(index){
        //ilay tr voalohany tsy raisina
        if(index > 0){
            //i=0 lundi
            //i=1 mardi...
            for(var i=0; i<5; i++){
                switch (i) {
                    case 0:
                        var id = "lundi";
                        break;
                    case 1:
                        var id = "mardi";
                        break;
                    case 2:
                        var id = "mercredi";
                        break;
                    case 3:
                        var id = "jeudi";
                        break;
                    case 4:
                        var id = "vendredi";
                        break;
                }
                $(this).append("<td class=\""+id+"\">"+addSelect(matieres, id, index)+"</td>");
            }
        }
    });
    /**
     * ajouter une balise select
     * @param {*} matieres les options
     * @param {*} id 
     * @param {*} index heure (premier:1, deuxieme:2)
     * @returns 
     */
    function addSelect(matieres, id, index) { 
        //ouvrir la balise select
        //{index} index de <tr> ≃ heure
        switch (id) {
            case "lundi":
                var idSelect = "lun_h"+index;
                break;
            case "mardi":
                var idSelect = "mar_h"+index;
                break;
            case "mercredi":
             var idSelect = "mer_h"+index;
            break;
            case "jeudi":
                var idSelect = "jeu_h"+index;
                break;
            case "vendredi":
                var idSelect = "ven_h"+index;
                break;
        }
        str = "<select name=\""+idSelect+"\" class='form-control' id=\""+idSelect+"\"><option value=''></option>";

        //on ajoute les options
        for(var i=0; i<matieres.length; i++){
            str += "<option value=\""+ matieres[i].toLowerCase()+"\">"+ matieres[i]+"</option>";
        }

        //on ferme la balise select
        str += "</select>";
        return str;
    }

    /**
     * 
     * @param {*} jour en trois lettres français ex: lun,mar...
     */
    function edtParJour(jour) { 
        var str = '';
        jour = jour+"_h".toLowerCase();
        $('select[id*='+jour+']').each(function(index){
            if($(this).val() != '') {
                str += jour+(index+1) + ":" + $(this).val() + ", ";
            }
            else{
                str += jour+(index+1) + ":null,";
            }
        })
        //misy farany "," leizy de esorina iny
        return str = str.slice(0, -1);
    }
    
    /**
     * creation de balise input
     * @param {*} id 
     * @param {*} name 
     * @param {*} type 
     * @param {*} value 
     */
    function createInput( id, name, type, value ) {
        $('#form').append('<input name="'+name+'" type="'+type+'" id="'+id+'" value="'+value+'">');
    }

    //envoi des tabs en string vers le php
    $('#btn').click(function(){
        //semaine de l'emploi du temps
        if($('#debutDate').val() == '') {
            alert("Veuillez indiquez la semaine de l'emploi du temps");
            return;
        }
        var semaineDe = $('#debutDate').val();
        $('#semaineDe').val(semaineDe);

        (edtParJour('lun') != '') ? createInput('lundi', 'lundi', 'text', edtParJour('lun')) : '';
        (edtParJour('mar') != '') ? createInput('mardi', 'mardi', 'text', edtParJour('mar')) : '';
        (edtParJour('mer') != '') ? createInput('mercredi', 'mercredi', 'text', edtParJour('mer')) : '';
        (edtParJour('jeu') != '') ? createInput('jeudi', 'jeudi', 'text', edtParJour('jeu')) : '';
        (edtParJour('ven') != '') ? createInput('vendredi', 'vendredi', 'text', edtParJour('ven')) : '';
        $('#submit').click();
    });
})