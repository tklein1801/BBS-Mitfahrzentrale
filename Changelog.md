## Changelogs

### [BBS-Mitfahrzentrale v0.4-pre](https://github.com/tklein1801/BBS-Mitfahrzentrale/releases/tag/v0.4-pre)

#### Hinzugefügt

- [DulliAG Snackbar](https://github.com/DulliAG/Snackbar) für Benutzeraktionen als Feedback eingeführt
- Nur bestimme Emailadresse beim Registrieren zulassen

#### Geändert

- API-Dokumentation überarbeiten
- Kleinere Änderungen am Design vorgenommen
- Ein paar ungenutze API-Endpoints wurden vorübergehend deaktiviert
- [ ] [DB] Neue datenbank.sql erstellen
  - Adminaccount erstellen
- Logs überarbeiten
  - Methode zum erstellen eines Logs in der `index.php`
  - [ ] Logs informativ verbessern
- Adminbereich umstrukturiert
  - Neues Layout
  - Bereiche gliedern
  - Performance verbessern
  - [ ] Suchleiste einbauen
- PHP-Komponenten überarbeitet & erweitert
  - [ ] Neue Komponenten erstellt
  - [ ] HTML-Scripte werden automatisch mit importiert

#### Entfernt

- [PHP] Nested-Statements entfernt um 8.0 kompatibel zu machen
- [ ] **Können wir die Admin-Endpoints entfernen und die normalen Endpoints verwenden falls dieser von einem Admin abgerufen wird?**

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
