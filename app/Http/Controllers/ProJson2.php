

"Properties":[
    {
        "id": String,
        "title": String, 
        "desc": String, 
        "propertyType": String,
        "projectTitle": String 
        "propertyStatus": String, 
        "location" : {     
            "lat": Float, 
            "lng": Float
        },
        "formattedAddress" : String, 
        "features": [ 
            {
                "name": String,
                "area": {
                    "value": String,
                    "unit": String
                }
            },
        ],
        "featured": Boolean, 
        "price": { 
            "sale": Float, 
            "rent": Float  
        },
        "initialContribution": { 
            "percentage": Integer,
        },
        "monthlyPayment": Float,
        "paymentDeadline": {
            "value": Integer,
            "unit":  String
        },
        "deliveryTime": { 
            "value": Integer,
            "unit":  String
        }
        "bedrooms": Integer, 
        "rooms": Integer, 
        "area": {
            "ground": Float, 
            "used": Float, 
            "unit": String 
        },
        "additionalFeatures": [          
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
        "plans": [ 
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

    }
    ]
    Tu peux donner "le controller" pour une API laravel 9 pour afficher les propriétés exactement comme ce modèle en tenant compte de la relation entre les tables ?
