<h1 align="center">BBS-Mitfahrzentrale</h1>

## :card_file_box: Inhalt

1. [Allgemeines](#allgemeines)
2. [Bedienungsanleitung](#page_facing_up-bedienungsanleitung)
3. [Installation](#wrench-installation)
4. [Umgesetzt mithilfe von](#link-umgesetzt-mithilfe-von)

---

## 🧐 Allgemeines

**Die BBS-MItfahrzentrale** kann als eine **Testversion** [hier](https://bbs.dulliag.de) aufgerufen werden. Informationen zum Webserver, Datenbank und PHP-Version sind unten zu finden.

**Server Betriebsystem**: Debian 9.13

**Datenbank**: 10.1.45-MariaDB

**Webserver**: apache/2.4.25

**PHP Version**: 7.3.26

---

## :page_facing_up: Bedienungsanleitung

_Eine bebilderte Bedienungsanleitung findest du [hier](./assets/doc/Bedienungsanleitung.pdf)._

---

## :wrench: Installation

_Eine bebilderte Installationsanleitung findest du [hier](./assets/doc/Installieren.pdf)._

1. GitHub-Repository mittels `git clone https://github.com/tklein1801/BBS-Mitfahrzentrale.git` herunterladen. _Alternativ kann man das Projekt als .zip [hier](https://github.com/tklein1801/BBS-Mitfahrzentrale/archive/main.zip) herunterladen und selber auf dem Server hochladen._

2. Eintragen der Zugangsdaten(Host, Username, Password) für die Datenbank in der Datei [`./endpoints/sql.php`](endpoints/sql.php)
   _(Der Datenbankname wurde bereits voreingestellt und muss nicht mehr angepasst werden)_

   2.1 Erstellen der Tabellen und Beziehungen mithilfe der [`./database/database.sql`](database/database.sql).
   _(Alternativ können die Tabellen und Beziehungen auf in phpMyAdmin über die 'Importieren' funktion erstellt werden)_

   _2.2 Eintragen der Postleitzahlen mittels [`./database/plz.sql`](database/plz.sql)._
   _(Auch diese kann in phpMyAdmin durch die 'Importieren' funktion importiert werden. **Für das Nutzen der BBS-Mitfahrzentrale sind die Daten der plz.sql jedoch nicht erforderlich da dieses Feature noch nicht für den Benutzer verfügbar ist!**)_

3. Die aktuelle Zeitzone kann in der [`index.php`](index.php#L9) eingestellt werden.
   _(Die Zeitzone beim Download beträgt automatisch 'Europe/Berlin' und muss nur angepasst werden wenn man sich in einer anderen Zeitzone befindet.)_

**Nun sollte die Anwendung erreichbar sein und die Nutzer sollten sich registrieren können.**

---

## :link: Umgesetzt mithilfe von

[BBS Soltau](https://bbssoltau.de) _(Logo, Farbschema, Hamburger SVG)_
[Bootstrap v5.0.0-beta1](https://getbootstrap.com/)
[Fontawesome v5.6.3](https://fontawesome.com)
[PHP Router](https://github.com/steampixel/simplePHPRouter/tree/master)
[NanoID](https://github.com/ai/nanoid)
