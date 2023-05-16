Property
	{
		"id": String,
		"title": String, // nom du bien ou de la propriété
		"desc": String,  // description de la propriété
		"propertyType": String, // enum  ['Villa', 'Appartement']
		"projectTitle": String // le nom du projet affilié
		"propertyStatus": String, // à revoir
		"location" : {
			"lat": Float, // coordonné latitude pour google map
			"lng": Float  // coordonné longitude pour google map
		},
		"formattedAddress" : String,  // addresse
		"features": [ // liste des caractéristiques techniques
			{	// représentation d’une caractéristique technique
				"name": String,  // nom de la caractéristique
				"area": {	// surface de la caractéristique
					"value": String,  // valeur de la surface 
					"unit": String // unité de la surface
				}
			},
		],
		"featured": Boolean, // nous permet de savoir si c’est un //bien qui fait parti des meilleurs offres
		"price": { // prix de pa propriété
			"sale": Float,	// prix TTC
			"rent": Float	// prix location
		},
		"initialContribution": { //la contribution initial
			"percentage": Integer, // le pourcentage de cette //contribution
		},
		"monthlyPayment": Float, // versement mensuel
		"paymentDeadline": { // Temps limite de paiement
			"value": Integer,  // valeur ex: 36
			"unit":  String   // unité ex: mois/année …
		},
		"deliveryTime": { // temps de livraison
			"value": Integer,  //valeur ex: 24
			"unit":  String  // unité ex: mois/année …
		}
		"bedrooms": Integer, // Nombre de chambre
		"rooms": Integer, // Nombre de pièce
		"area": {
			"ground": Float, // Surface terrain
			"used": Float, // Surface utilisé
			"unit": String // unité de mesure
		},
		"additionalFeatures": [   //caractéristiques additionnel        
			{
				"name": String,
				"value": String
			}
		],
		"gallery": [         
			{
				"small": String,
				"medium": String,
				"big": String
			},
		],
		"plans": [ //plan de la propriété
			{
				"name": "First floor",
				"desc": String,
				"area": {
					"value": Float,
					"unit": String
				},
				"image": String
			},
		],
		"videos": [
			{
				"name": "name",
				"link": String
			},
		],
		"published": Date,
		"lastUpdate": Date,
	}
