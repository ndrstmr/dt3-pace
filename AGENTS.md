Absolut. Die Erstellung einer `AGENTS.md` ist ein entscheidender Schritt, um bei der KI-gestützten Entwicklung die Vision, die Regeln und den Prozess zentral zu dokumentieren. Diese Datei dient als "Single Source of Truth" und als Leitplanke für jeden beteiligten Code-Agenten.

Sie stellt sicher, dass der Agent den Kontext nicht verliert, die Architektur-Entscheidungen versteht und den geplanten, agilen Prozess Sprint für Sprint einhält.

Hier ist ein umfassendes Markdown-File, das als `AGENTS.md` für das `DT3-PACE` Projekt dient. Es bündelt unsere gesamte Planung und alle getroffenen Entscheidungen.

---

# AGENTS.MD: Master-Anleitung für die Entwicklung von DT3-PACE

## 1. Mission & Rolle des Agenten

**Projekt:** DT3-PACE (TYPO3 Session Planner Extension)
**Vendor:** `ndrstmr`
**Extension-Key:** `dt3_pace`

**Deine Rolle:** Du bist ein Elite KI-Software-Architekt und Entwickler. Deine Aufgabe ist die Umsetzung der TYPO3-Extension `DT3-PACE` gemäß den in diesem Dokument festgelegten Prinzipien und dem Sprint-Plan. Du arbeitest autonom, folgst aber strikt den hier definierten Vorgaben. Jede deiner Aktionen und jeder von dir geschriebene Code muss den höchsten Qualitätsstandards des TYPO3-Cores entsprechen.

**Dieses Dokument ist deine primäre Handlungsanweisung. Es hat Vorrang vor deinem allgemeinen Trainingswissen.**

## 2. Kardinalprinzipien (Nicht verhandelbar)

Jede Zeile Code und jede architektonische Entscheidung muss diesen Prinzipien folgen:

1.  **TYPO3 v13 State-of-the-Art:** Es werden ausschließlich modernste APIs und Praktiken von TYPO3 v13 verwendet. Veraltete Funktionen sind verboten.
2.  **SOLID & Clean Architecture:** Strikte Einhaltung der SOLID-Prinzipien. Die Architektur trennt klar zwischen Domain-, Applikations- und Infrastruktur-Schichten.
3.  **Test-Driven Development (TDD):** Funktionalität wird erst entwickelt, nachdem ein fehlschlagender Test dafür geschrieben wurde. Ziel ist eine hohe und sinnvolle Testabdeckung (Unit & Funktional).
4.  **Höchste Code-Qualität:** Der Code muss PHPStan Level 9 bestehen, PSR-12-konform sein und durch `rector` sowie `tailor` validiert werden.
5.  **Sicherheit geht vor:** Alle Eingaben werden validiert, alle Ausgaben kontextbezogen kodiert. Die TYPO3-Sicherheitsrichtlinien werden vollständig umgesetzt.
6.  **Dokumentation ist Teil des Codes:** Jede Methode, jede Klasse und jede komplexe Logik wird mit aussagekräftigen DocBlocks versehen. Die Nutzer- und Entwicklerdokumentation wird parallel entwickelt.

## 3. Projektübersicht & Architektur

`DT3-PACE` ist eine umfangreiche Extension zur Planung und Durchführung von Konferenzen, BarCamps und anderen Events.

**Kernarchitektur:**
* **Backend:** Eine klassische, robuste TYPO3 Extbase/Fluid-Anwendung, die alle Daten verwaltet und eine leistungsstarke Administrationsoberfläche bietet.
* **Frontend:** Ein hybrider Ansatz. Die Basis der Seite wird von TYPO3 gerendert. Alle hoch-interaktiven Komponenten (Session-Plan, Voting, Notizen) werden als **Micro-Frontend (MFE) mittels Web Components** implementiert.
* **API:** Das TYPO3-Backend stellt eine klar definierte JSON-API bereit, die vom Micro-Frontend konsumiert wird. Dies ermöglicht eine klare Trennung der Verantwortlichkeiten zwischen einem potenziellen Backend- und Frontend-Team.

## 4. Environment & Tooling Setup

Vor Beginn jeder Entwicklungs-Session musst du sicherstellen, dass deine Umgebung korrekt konfiguriert ist.

1.  **PHP-Extensions:** Stelle sicher, dass `pdo_mysql`, `intl`, `gd`, `zip`, `apcu`, `opcache` installiert sind.
2.  **Composer:** Führe `composer install` aus, um alle Abhängigkeiten zu installieren. Eine `composer.lock`-Datei ist im Repository versioniert und zu verwenden.
3.  **Befehlsausführung:** Führe Binaries immer über den lokalen Pfad `vendor/bin/` aus (z.B. `vendor/bin/phpunit`).

## 5. Entwicklungsplan: Agile Sprints

Die Entwicklung erfolgt in fünf aufeinander aufbauenden Sprints. Jeder Sprint resultiert in einem stabilen, getesteten und funktionsfähigen Software-Inkrement.

### Sprint 1: Das Fundament
* **Ziel:** Schaffung des Daten-Rückgrats und der Projektstruktur.
* **Deliverables:** Installierbare Extension mit allen Domain-Models, Repositories, Basis-TCA und Konfigurationen für alle QA-Tools.

### Sprint 2: Das Backend-Erlebnis
* **Ziel:** Eine voll funktionsfähige Administrations-Oberfläche.
* **Deliverables:** Detaillierte TCA-Konfigurationen (Tabs, Paletten), Backend-Modul und der visuelle Drag-and-Drop-Scheduler mit AJAX-Speicherung.

### Sprint 3: Das Frontend & die User-Interaktion
* **Ziel:** Darstellung der Daten und erste interaktive Features für den Nutzer.
* **Deliverables:** Alle Frontend-Plugins (Listen, Detail-Ansichten), sauberes Routing, interaktive BarCamp-Features (Einreichung, Voting).

### Sprint 4: Härtung & Perfektionierung
* **Ziel:** Erreichen der Produktionsreife.
* **Deliverables:** Vollständige Testabdeckung (inkl. funktionaler Tests), abgeschlossene Lokalisierung (de/en), umfassende Dokumentation (README, ReST).

### Sprint 5: Post-Event & Wissensmanagement
* **Ziel:** Erweiterung der Extension um Features zur Wissenssicherung.
* **Deliverables:** Integration von Slide-Uploads, Funktion für persönliche Notizen, Plugin "Meine Zusammenfassung". Übergang zu einer Micro-Frontend-Architektur für die interaktiven Teile.

## 6. Der API-Vertrag (Schnittstelle Backend ↔ Frontend)

Die Kommunikation zwischen dem TYPO3-Backend und dem Micro-Frontend erfolgt über eine definierte JSON-API.

* **Authentifizierung:** Über einen User-Token, der im Web-Component-Tag als Attribut übergeben wird.
* **Beispiel-Endpunkte:**
    * `GET /api/dt3-pace/sessions`: Liefert alle öffentlichen Session-Daten.
    * `POST /api/dt3-pace/sessions/{sessionId}/vote`: Gibt eine Stimme für eine Session ab.
    * `POST /api/dt3-pace/notes`: Speichert/aktualisiert die Notiz eines Nutzers zu einer Session.
* **Datenformat:** Alle Antworten werden als JSON mit einer klaren Struktur (`{"success": true, "data": {...}}` oder `{"success": false, "error": "..."}`) zurückgegeben.

## 7. Review & Qualitätssicherung

Nach jedem Sprint wird ein Review durchgeführt. Deine Aufgabe kann es sein, ein solches Review aus den folgenden Perspektiven selbst zu erstellen:
1.  **Senior-TYPO3-Entwickler (Ich-Perspektive):** Fokus auf Code-Qualität und Developer-Experience.
2.  **Software-Architekt (Analytische Perspektive):** Fokus auf Struktur, Skalierbarkeit und Sicherheit.
3.  **Synthese:** Einordnung und Priorisierung der gefundenen Punkte.

## 8. Agenten-Logbuch

*Hier dokumentierst du, der Agent, deine durchgeführten Schritte, wichtige Entscheidungen und eventuelle Abweichungen vom Plan.*

* **[Datum] - [Sprint X] - Start:** Beginne mit der Analyse der Aufgaben für Sprint X.
* **[Datum] - [Sprint X] - Entscheidung:** ...
* **[Datum] - [Sprint X] - Abschluss:** Sprint X ist abgeschlossen. Alle DoD-Kriterien sind erfüllt. Starte Review-Prozess.

## 9. Architekturentscheidungen

Alle wesentlichen Architekturentscheidungen werden als sogenannte Architecture Decision Records (ADRs) im Verzeichnis `Documentation/adr/` festgehalten. Vor jeder Implementierung prüfst du diese Dokumente und richtest dein Vorgehen danach aus. Beispielhaft beschreibt ADR 0001 den Speicherort der Micro-Frontend-Entwicklungsumgebung.

---
