# Endpoints

## Allgemeine Informationen

**Logs**

> Es werden nur Anfragen an die API geloggt und in der Datenbank gespeichert

**Authentifizierung**

> Der API-Key welcher für bestimmte Endpoints mitgeschickt werden muss (erkenntlich gemacht durch Authentification: (string) apiKey) muss mit der Anfrage verschickt werden und wird nicht extra bei den Parametern der Anfrage aufgelistet!

> Sollte der Benutzer angemeldet sein muss kein API-Key für die Authentifizierung mitgeschickt werden

---

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

---

## user

**Registrieren eines neuen Benutzers**

```
POST /api/user/register
Params: (string) name, (string) surname, (string) email, (string) password, (string) telNumber
Response 200 (application/json)
```

**Überprüfen der Anmeldedaten eines Benutzers**

```
GET /api/user/checkCredentials
Params: (string) email, (string) password
Response 200 (application/json)
```

**Prüfen ob ein Benutzer bereits existiert**

```
GET /api/user/exist
Params: (string) email
Response 200 (application/json)
```

**Abmelden eines Benutzers durch beenden der Sitzung**

```
GET /api/user/destroySession
Params: (string) redirectTo
Response 200 (application/json)
```

**Abrufen der Benutzerinformationen eines spezifischen Benutzers**

```
POST /api/user/get
Authentification: (string) apiKey
Response 200 (application/json)
```

**Updaten der Benutzerinformationen eines Benutzers**

```
POST /api/user/update
Authentification: (string) apiKey
Params: (string) phone, (string|null) password
Response 200 (application/json)
```

---

## admin

> Sämtliche admin-Endpoints sind durch den API-Key geschützt und können nur erfolgreich von einem Admin-Account angefragt werden

**Abrufen der Benutzerinformationen eines spezifischen Benutzers**

```
POST /api/admin/user/get
Authentification: (string) apiKey
Params: (int) userId
Response 200 (application/json)
```

**Bearbeiten eines Benutzers**

```
POST /api/admin/user/update
Authentification: (string) apiKey
Params: (int) userId, (int) verified, (int) admin, (string) name, (string) surname, (string) email, (string) phone, (string|null) password
Response 200 (application/json)
```

**Abrufen aller aktiven Anzeigen eines Benutzers**

```
POST /api/admin/ride/user
Authentification: (string) apiKey
Params: (int) userId
Response 200 (application/json)
```

**Abrufen aller aktiven Anzeigen**

```
POST /api/admin/ride/all
Authentification: (string) apiKey
Response 200 (application/json)
```

**Abrufen einer bestimmten Anzeige**

```
POST /api/admin/ride/offer
Authentification: (int) rideId
Response 200 (application/json)
```

**Bearbeiten einer bestehenden Anzeige**

```
POST /api/admin/ride/update
Authentification: (int) rideId, (string) title, (string) information, (int) price, (int) seats, (int) startAt, (int) startPlz, (string) startCity, (string) startAdress, (int) destinationPlz, (string) destinationCity, (string) destinationAdress
Response 200 (application/json)
```

---

## plz

> Die plz-Endpoints sind derzeit nicht erreichbar.
> Die Endpoints können in der [`index.php`](../../index.php) wieder aktiviert werden

**Abrufen aller Orte mit Namensübereinstimmung**

```
GET /api/plz/placesByPlz
Params: (int) plz
Response 200 (application/json)
```

**Abrufen eines Ortes mittels Postleitzahl**

```
GET /api/plz/placeByPlz
Params: (int) plz
Response 200 (application/json)
```

**Abrufen eines Ortes mittels Name**

```
GET /api/plz/plzByName
Params: (string) cityName
Response 200 (application/json)
```

---

## ride

**Erstellen einer neuen Anzeige**

```
POST /api/ride/create
Authentification: (string) apiKey
Params: (int) driver, (string) title, (string) information, (int) price, (int) seats, (int) startAt, (int) startPlz, (string) startCity, (string) startAdress, (int) destinationPlz, (string) destinationCity, (string) destinationAdress
Response 200 (application/json)
```

**Bearbeiten einer bestehenden Anzeige**

```
POST /api/ride/update
Authentification: (string) apiKey
Params: (int) rideId, (string) information, (int) price, (int) seats, (int) startAt, (int) startPlz, (string) startCity, (string) startAdress, (int) destinationPlz, (string) destinationCity, (string) destinationAdress
Response 200 (application/json)
```

**Löschen einer bestehenden Anzeige**

```
POST /api/ride/delete
Authentification: (string) apiKey
Params: (int) rideId
Response 200 (application/json)
```

**Abrufen aller aktiven Anzeigen**

```
GET /api/ride/all
Response 200 (application/json)
```

**Abrufen einer Anzeige**

```
GET /api/ride/offer
Params: (int) rideId
Response 200 (application/json)
```

**Abrufen aller aktiven Fahrangebote**

```
GET /api/ride/offers
Response 200 (application/json)
```

**Abrufen aller aktiven Fahrgesuche**

```
GET /api/ride/requests
Response 200 (application/json)
```

**Abrufen aller aktiven Anzeigen eines Benutzers**

```
POST /api/ride/user
Authentification: (string) apiKey
Response 200 (application/json)
```

**Abrufen aller aktiven favorisierten Anzeigen eines Benutzers**

> Dieser Endpoint ist derzeit nicht erreichbar da die Funktion der Favoriten derzeit noch nicht implementiert wurde

```
GET /api/ride/favorites
Authentification: (string) apiKey
Response 200 (application/json)
```
