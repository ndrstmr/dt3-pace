# dt3_pace

[![CI](https://github.com/ndrstmr/dt3-pace/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/ndrstmr/dt3-pace/actions/workflows/ci.yml)
[![License](https://img.shields.io/github/license/ndrstmr/dt3_pace)](https://github.com/ndrstmr/dt3-pace/blob/main/LICENSE)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](https://phpstan.org/)

> **Achtung: Automatisch generierter Code**
> Dieser Code wurde von einem KI-Code-Agenten (OpenAi Codex - ein Cloud-basierter Software-Engineering-Agent) auf Basis von detaillierten Prompts erstellt. Er dient als Grundlage und Beschleuniger für die Entwicklung.
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

## License

This project is licensed under the [EUPL 1.2](LICENSE).

