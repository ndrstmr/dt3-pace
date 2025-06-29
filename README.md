# dt3_pace

> **Achtung: Automatisch generierter Code**
> Dieser Code wurde von einem KI-Code-Agenten (Google Gemini) auf Basis eines detaillierten Prompts erstellt. Er dient als Grundlage und Beschleuniger für die Entwicklung.
> Jeder Entwickler ist verpflichtet, den Code vor einem produktiven Einsatz eigenständig und sorgfältig zu überprüfen, zu testen und gegebenenfalls anzupassen. Es wird keinerlei Haftung für Fehler, Sicherheitslücken oder Fehlfunktionen übernommen.

PACE - Planning And Conference Engine
=====================================

This TYPO3 extension provides a basic data model and tooling for managing conference sessions and schedules.

Sprint 1 delivers the initial domain models, simple backend integration and development tooling.

## Installation

1. Install the PHP dependencies via Composer:

   ```bash
   composer install
   ```

   When running inside CI or without the required PHP extensions you can use:

   ```bash
   composer install --ignore-platform-reqs
   ```

2. Add the extension to your TYPO3 installation (e.g. via `composer req ndrstmr/dt3_pace` or by placing it in `typo3conf/ext`).
3. Activate the extension in the TYPO3 Extension Manager.

## Example usage

Once installed you can use the provided plugins to display sessions and speakers or to collect session proposals and votes. Add the desired plugin to a page via the list module and select one of:

* Agenda list (`Agendalist`)
* Agenda grid (`Agendagrid`)
* Session show (`Sessionshow`)
* Speaker list (`Speakerlist`)
* Speaker show (`Speakershow`)
* Session form (`Sessionform`)
* Session voting (`Sessionvoting`)
* Event summary (`Eventsummary`)

Backend modules are available under the "PACE" main module.

## Development

Run the unit and functional tests with PHPUnit:

```bash
vendor/bin/phpunit -c phpunit.xml.dist
```

Static code analysis with PHPStan can be executed via:

```bash
vendor/bin/phpstan analyse -c phpstan.neon.dist
```

Both commands require the development dependencies to be installed.
