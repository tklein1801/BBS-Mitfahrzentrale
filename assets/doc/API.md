# Endpoints

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

