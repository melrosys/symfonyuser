function search_engine(url) {
    $("#searchsug").autocomplete({
        source: function (requete, reponse) {
            $.ajax({
                url: url,
                dataType: 'json',
                data: {
                    name_startsWith: $('#searchsug').val(),
                    minLength: 3,
                    maxRows: 15
                },
                success: function (donnee) {
                    var autocompleteObjects = [];
                    var found = false;
                    var cmp = $('#searchsug').val();
                    $.map(donnee, function (objet) {
                        var name = objet.name;
                        var ville = objet.ville;
                        var id = objet.id;

                        var indexOfville = null;
                        if (ville != null) {indexOfville = ville.toLowerCase().indexOf(cmp.toLowerCase());}
                        else { indexOfville = -1;}
                    
                        var indexOfname = null;
                        if (name != null) {indexOfname = name.toLowerCase().indexOf(cmp.toLowerCase());}
                        else { indexOfname = -1;}

                        if (indexOfname != -1 || indexOfville != -1) {
                            if(ville == null) ville = "ville non indiqé";
                            var object = {
                                value: name + " / "+ville,
                                label: name + " / " + ville,
                                id: id
                            };

                            autocompleteObjects.push(object);
                            found = true;
                        }
                    });

                    if (found) {
                        reponse(autocompleteObjects);
                    }
                    else {
                        var object = {

                            value: cmp,
                            label: "Aucun résultat!",
                            id: -1
                        };

                        autocompleteObjects.push(object);
                        reponse(autocompleteObjects);
                    }
                }
            });
        },
        select: function (a, b) {
            var id = b.item.id;
            window.location = "http://127.0.0.1:8000/admin/entites/entite/" + id;
        }
    });
}