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
                        var title = objet.title;
                        var tags = objet.tags;
                        var id = objet.id;

                        var indexOftags = null;
                        if (tags != null) { indexOftags = tags.toLowerCase().indexOf(cmp.toLowerCase()); }
                        else { indexOftags = -1; }

                        if (indexOftags != -1) {
                            var object = {
                                value: title,
                                label: title,
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
            window.location = "http://127.0.0.1:8000/admin/device/list/" + id;
        }
    });
}