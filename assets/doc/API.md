# Endpoints

## Fehlermeldungen

| Fehlermeldung             | Bedeutung                                                      |
| ------------------------- | -------------------------------------------------------------- |
| `auth/user-already-exist` | Der Benutzer existiert bereits                                 |
| `auth/user-not-found`     | Der Benutzer existiert nicht                                   |
| `auth/password-invalid`   | Das Passwort passt nicht zur angegeben E-Mail                  |
| `auth/key-invalid`        | `RestAPI` Der angegebene API-Key existiert nicht               |
| `auth/key-not-set`        | `RestAPI` Es wurde kein API-Key zur authentifizierung gefunden |
| `ride/not-the-creator`    | Du bist nicht der Ersteller der Anzeiger                       |

## user

```
POST /register
Params: (string) name, (string) surname, (string) email, (string) password, (string) adress, (int) plz, (string) place, (string) telNumber
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
GET /get
Authentification: (string) apiKey
Params: (string) apiKey
Response 200 (application/json)
```

```
POST /update
Authentification: (string) apiKey
Params: (string) apiKey, (string) phone, (string) password
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

_If the user is signed in the api-key is set by default_

```
POST /create
Authentification: (string) apiKey
Params: (string) apiKey, (int) driver, (string) title, (string) information, (int) price, (int) seats, (int) startAt, (int) startPlz, (string) startCity, (string) startAdress, (int) destinationPlz, (string) destinationCity, (string) destinationAdress
Response 200 (application/json)
```

```
POST /update
Authentification: (string) apiKey
Params: (string) apiKey, (int) rideId, (string) information, (int) price, (int) seats, (int) startAt, (int) startPlz, (string) startCity, (string) startAdress, (int) destinationPlz, (string) destinationCity, (string) destinationAdress
Response 200 (application/json)
```

```
POST /delete
Authentification: (string) apiKey
Params: (string) apiKey, (int) rideId
Response 200 (application/json)
```

```
GET /all
Response 200 (application/json)
```

```
GET /favorites
Authentification: (string) apiKey
Params: (string) apiKey
Response 200 (application/json)
```

```
GET /user
Authentification: (string) apiKey
Params: (string) apiKey
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
