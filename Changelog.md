## Changelogs

### [BBS-Mitfahrzentrale v0.5-pre](https://github.com/tklein1801/BBS-Mitfahrzentrale/releases/tag/v0.5-pre)

#### Hinzugefügt

- **Seitennummerierung** für Logs wurden hinzugefügt
- **Keine Treffer**-Nachricht für den Adminbereich hinzugefügt
- **Mailer & MailTemplates** wurden hinzugefügt
- Benutzer kann/muss seine E-Mail Adresse nach dem Registrieren bestätigen
  - Bestätigungsmail wird nach dem registrieren automatisch verschickt
  - Benutzer ist in der Lage die Bestätigungsmail erneut anzufordern
  - Anzeigen können erst nach dem bestätigen der E-Mail Adresse erstellt werden
- Passwort zurücksetzen wurde für den Benutzer ermöglicht
  - E-Mail für die Weiterleitung wird dem Benutzer auf Anfrage zugestellt
  - Benutzer kann das Passwort über einen besonderen Link welcher per E-Mail zugestellt wird zurück setzen

#### Geändert

- **Routen** zum Adminbereich wurden geändert
- Icon in der Navbar wurde durch das Profilbild ausgetauscht
- Modals schließen nun direkt nach dem abschicken des Formulares
- PHP Komponenten wurden verschoben & wurden neu "verlinkt"

#### Entfernt

- Methode `new User()->sendVerificationEmail()` wurde entfernt

---

### [BBS-Mitfahrzentrale v0.4-pre](https://github.com/tklein1801/BBS-Mitfahrzentrale/releases/tag/v0.4-pre)

#### Hinzugefügt

- [DulliAG Snackbar](https://github.com/DulliAG/Snackbar) für Benutzeraktionen als Feedback eingeführt
- Nur bestimme Emailadresse beim Registrieren zulassen

#### Geändert

- API-Dokumentation überarbeiten
- Kleinere Änderungen am Design vorgenommen
- Ein paar ungenutze API-Endpoints wurden vorübergehend deaktiviert
- [DB] Neue datenbank.sql erstellen
- Logs überarbeiten
  - Methode zum erstellen eines Logs in der `index.php` verwenden
  - Statuscode speichern
  - Nur noch Rest-API werden geloggt
- Adminbereich umstrukturiert
  - Neues Layout
    - Sidebar auf kleineren Desktopgeräten angepasst
  - Bereiche aufgeteilt
  - Performance verbessert
  - Suchleiste einbauen _(Mittels Stichwörter nach bestimmten Anzeigen oder Benutzern suchen)_
- [PHP] Prüfen des abgefragten Pfads abwärtskompatibel gemacht
- PHP-Komponenten für den Adminbereich erstellt _(Um die mehrfache Nutzung gleicher HTML-Strukturen zu erleichtern)_

#### Entfernt

- Ehemaliger Adminbereich wurde entfernt
- [PHP] Nested-Statements entfernt um 8.0 kompatibel zu machen

---

### [BBS-Mitfahrzentrale v0.3-pre](https://github.com/tklein1801/BBS-Mitfahrzentrale/releases/tag/v0.3-pre)

#### Hinzugefügt

- **Adminbereich** wurde hinzugefügt
  - Benutzer einsehen & bearbeiten
  - Admins ernennen
  - Benutzer manuell verifizieren
  - Anzeigen einsehen & bearbeiten

#### Geändert

- **API-Dokumentation** wurde angepasst
- **BBS-Mitfahrzentrale Dokumentation** wurde angepasst
- **Kleinere Änderungen** am **Design** wurde mit dem Update hinzugefügt
- Es wird nun **eu.ui-avatars** anstelle von FontAwesome Icons als Profilbild verwendet
  _(Code wurde erst diesen Release eingebaut)_
- Änderungen an Endpoints sowie API wurden vorgenommen um diese kompatibel mit dem Adminbereich zu machen
