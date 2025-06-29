.. include:: /Includes.rst.txt

============================
DT3-PACE Documentation
============================

This is the starting point for the documentation of the dt3_pace extension.

Events
======

The extension dispatches several PSR-14 events that can be consumed by third-party
code:

* ``Ndrstmr\Dt3Pace\Event\AfterVoteAddedEvent`` – emitted after a ``Vote``
  entity has been persisted. The event provides access to the ``Vote`` object.
* ``Ndrstmr\Dt3Pace\Event\SessionStatusChangedEvent`` – emitted whenever a
  ``Session`` changes its status. Listeners receive the ``Session`` object as
  well as the old and new ``SessionStatus`` values.

Database Indexes and Migrations
===============================

Several database indexes improve lookup performance. If you maintain your schema
using Doctrine migrations create a new migration after installing or updating the
extension:

```
vendor/bin/typo3 doctrine:migrations:diff
```

Apply the generated migration or run the following SQL manually if migrations
are not used::

    CREATE INDEX idx_session_status ON tx_dt3pace_domain_model_session (status);
    CREATE INDEX idx_session_time_slot ON tx_dt3pace_domain_model_session (time_slot);
    CREATE INDEX idx_session_room ON tx_dt3pace_domain_model_session (room);
    CREATE UNIQUE INDEX uniq_session_slug ON tx_dt3pace_domain_model_session (slug);
    CREATE INDEX idx_vote_voter ON tx_dt3pace_domain_model_vote (voter);
    CREATE INDEX idx_vote_session ON tx_dt3pace_domain_model_vote (session);
    ALTER TABLE tx_dt3pace_domain_model_vote
        ADD CONSTRAINT uniq_session_voter UNIQUE (session_id, voter_id);

Scheduler Permissions
=====================

Only backend users with sufficient permissions should access the scheduler
module. By default the module requires admin privileges. You can change this
via the extension configuration::

    $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['dt3_pace']['schedulerModuleAccess'] = 'user,group';

Assign the module to specific backend groups after adjusting the access value.

Editor Guide
============

Editors create and manage sessions and speakers using the backend modules
"Sessions" and "Speakers". Schedule sessions by opening the "Scheduler" module
and drag the records onto the desired time slots. Save the changes via the
"Update" button.

Developer Notes
===============

Install the dependencies with ``composer install`` and run the QA tools before
submitting patches::

    vendor/bin/phpstan analyse
    vendor/bin/phpunit

Extension Hooks
===============

Listen to ``AfterVoteAddedEvent`` or ``SessionStatusChangedEvent`` to trigger
custom logic when votes are cast or session statuses change.

Contribution Guide
==================

Pull requests are welcome. Follow PSR-12 coding style and make sure all tests
pass before opening a PR.
