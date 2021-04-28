# Endpoints

## Fehlermeldungen

| Fehlermeldung             | Bedeutung                                                      |
| ------------------------- | -------------------------------------------------------------- |
| `auth/user-already-exist` | Der Benutzer existiert bereits                                 |
| `auth/user-not-found`     | Der Benutzer existiert nicht                                   |
| `auth/not-an-admin`       | Der Benutzer ist kein Admin                                    |
| `auth/password-invalid`   | Das Passwort passt nicht zur angegeben E-Mail                  |
| `auth/key-invalid`        | `RestAPI` Der angegebene API-Key existiert nicht               |
| `auth/key-not-set`        | `RestAPI` Es wurde kein API-Key zur authentifizierung gefunden |
| `ride/not-the-creator`    | Du bist nicht der Ersteller der Anzeiger                       |

> Der API-Key welcher für bestimmte Endpoints mitgeschickt werden muss (erkenntlich gemacht durch Authentification: (string) apiKey) muss als POST-Parameter mit der Anfrage verschickt werden und wird nicht extra bei den Parametern der Anfrage aufgelistet!

## user

```
POST /register
Params: (string) name, (string) surname, (string) email, (string) password, (string) telNumber
Response 200 (application/json)
```

```
GET /checkCredentials
Params: (string) email, (string) password
Response 200 (application/json)
```

```
GET /exist
Params: (string) email
Response 200 (application/json)
```

```
GET /destroySession
Params: (string) redirectTo
Response 200 (application/json)
```

```
POST /get
Authentification: (string) apiKey
Response 200 (application/json)
```

```
POST /update
Authentification: (string) apiKey
Params: (string) phone, (string|null) password
Response 200 (application/json)
```

## admin

```
POST /user/get
Authentification: (string) apiKey
Params: (int) userId
Response 200 (application/json)
```

```
POST /user/update
Authentification: (string) apiKey
Params: (int) userId, (int) verified, (int) admin, (string) name, (string) surname, (string) email, (string) phone, (string|null) password
Response 200 (application/json)
```

```
POST /ride/user
Authentification: (string) apiKey
Params: (int) userId
Response 200 (application/json)
```

```
POST /ride/all
Authentification: (string) apiKey
Response 200 (application/json)
```

```
POST /ride/offer
Authentification: (int) rideId
Response 200 (application/json)
```

```
POST /ride/update
Authentification: (int) rideId, (string) title, (string) information, (int) price, (int) seats, (int) startAt, (int) startPlz, (string) startCity, (string) startAdress, (int) destinationPlz, (string) destinationCity, (string) destinationAdress
Response 200 (application/json)
```

## plz

```
GET /placesByPlz
Params: (int) plz
Response 200 (application/json)
```

```
GET /placeByPlz
Params: (int) plz
Response 200 (application/json)
```

```
GET /plzByName
Params: (string) cityName
Response 200 (application/json)
```

## ride

> _If the user is signed in the api-key is set by default_

```
POST /create
Authentification: (string) apiKey
Params: (int) driver, (string) title, (string) information, (int) price, (int) seats, (int) startAt, (int) startPlz, (string) startCity, (string) startAdress, (int) destinationPlz, (string) destinationCity, (string) destinationAdress
Response 200 (application/json)
```

```
POST /update
Authentification: (string) apiKey
Params: (int) rideId, (string) information, (int) price, (int) seats, (int) startAt, (int) startPlz, (string) startCity, (string) startAdress, (int) destinationPlz, (string) destinationCity, (string) destinationAdress
Response 200 (application/json)
```

```
POST /delete
Authentification: (string) apiKey
Params: (int) rideId
Response 200 (application/json)
```

```
GET /all
Response 200 (application/json)
```

```
GET /favorites
Authentification: (string) apiKey
Response 200 (application/json)
```

```
POST /user
Authentification: (string) apiKey
Response 200 (application/json)
```

```
GET /offer
Params: (int) rideId
Response 200 (application/json)
```

```
GET /offers
Response 200 (application/json)
```

```
GET /requests
Response 200 (application/json)
```
