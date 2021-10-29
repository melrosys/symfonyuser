	function search_engine(url)
	{
		$("#searchsug").autocomplete({source : function(requete, reponse){
			$.ajax({
					url : url,
					dataType : 'json',
					data : {
						name_startsWith : $('#searchsug').val(),
						minLength : 3,
						maxRows : 15
					},
					success : function(donnee){
						var autocompleteObjects = [];
						var found = false;
						var cmp = $('#searchsug').val();
						$.map(donnee, function(objet){
							var name = objet.name;
							var email = objet.email;
							var id = objet.id;

							var indexOfname = name.toLowerCase().indexOf(cmp.toLowerCase());
							var indexOfemail = email.toLowerCase().indexOf(cmp.toLowerCase());

							
							if (indexOfemail != -1 || indexOfname!=-1)
							{
								var object = {

									value: name + " - " + email,
									label: name + " - " + email,
									id: id
								};

								autocompleteObjects.push(object);
								found = true;
							}
						});
						
						if(found) {
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
				window.location = "http://127.0.0.1:8000/admin/users/" + id;
			}
		});
	}
