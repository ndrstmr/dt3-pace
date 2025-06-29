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
    CREATE INDEX idx_vote_voter ON tx_dt3pace_domain_model_vote (voter);
    CREATE INDEX idx_vote_session ON tx_dt3pace_domain_model_vote (session);

Scheduler Permissions
=====================

Only backend users with sufficient permissions should access the scheduler
module. By default the module requires admin privileges. You can change this
via the extension configuration::

    $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['dt3_pace']['schedulerModuleAccess'] = 'user,group';

Assign the module to specific backend groups after adjusting the access value.
